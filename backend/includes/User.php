<?php
    class User implements Serializable, ArrayAccess
    {
        private static $users = array();
        protected $userdata;
        protected $database;
        
        private function __construct($name, $password)
        {
            try
            {
                $this->database = DatabaseManager::instance()->getDatabase();
                $query = 'SELECT * FROM ' . $this->database->getPrefix() . 'users WHERE name=?';
                $result = $this->database->preparedQuery($query, array($name));
                if (count($result) < 1)
                {
                    throw new Exception('User does not exist!', 1);
                }
                $result = $result[0];
                $salt = self::getSalt();
                if (hash('SHA512', $password . $salt) !== $result['password'])
                {
                    throw new Exception('Invalid password!', 2);
                }
                $crypter = self::getCrypter($password);
                $mailCrypter = self::getCrypter(Config::instance('bukkitweb')->get('encryptionKey'));
                
                $result['email'] = $mailCrypter->decrypt($result['email']);
                $result['serveraddress'] = $crypter->decrypt($result['serveraddress']);
                $result['apiport'] = $crypter->decrypt($result['apiport']);
                $result['apipassword'] = $crypter->decrypt($result['apipassword']);
                unset($result['password']);
                $this->userdata = $result;
                
                // Stats
                Statistics::increment('user.login');
            }
            catch (PDOException $e)
            {
                throw new Exception("Failed to load the user! Error: " . $e->getMessage(), -1);
            }
        }
        
        private function __clone()
        {}
        
        public static function get($username, $password)
        {
            if (!isset(self::$users[$username]))
            {
                self::$users[$username] = new self($username, $password);
            }
            return self::$users[$username];
        }
        
        public function getName()
        {
            return $this->userdata['name'];
        }
        
        public function getEmail()
        {
            return $this->userdata['email'];
        }
        
        public function getServerAddress()
        {
            return $this->userdata['serveraddress'];
        }
        
        public function getApiPort()
        {
            return $this->userdata['apiport'];
        }
        
        public function getApiAuthKey()
        {
            return $this->userdata['apipassword'];
        }
        
        public function removeUser()
        {
            try
            {
                $query = 'DELETE FROM ' . $this->database->getPrefix() . 'users WHERE name=?';
                $this->database->preparedQuery($query, array($this->getName()));
                return true;
            }
            catch (PDOException $e)
            {
                return false;
            }
        }
        
        
        public static function addUser($name, $pass, $email, $serveraddr, $apiport, $apipass)
        {
            try
            {
                if (User::exists($name))
                {
                    throw new Exception('User does already exist!', 5);
                }
                
                $db = DatabaseManager::instance()->getDatabase();
                $query = 'INSERT INTO ' . $db->getPrefix() . 'users (name, password, email, serveraddress, apiport, apipassword) '
                       . 'VALUES (?, ?, ?, ?, ?, ?)';
                $salt = self::getSalt();
                $crypter = self::getCrypter($pass);
                $mailCrypter = self::getCrypter(Config::instance('bukkitweb')->get('encryptionKey'));
                $db->preparedQuery($query, array(
                    substr($name, 0, 40),
                    hash('SHA512', $pass . $salt),
                    $mailCrypter->encrypt($email),
                    $crypter->encrypt($serveraddr),
                    $crypter->encrypt($apiport),
                    $crypter->encrypt($apipass)
                ), false);
                
                // Stats
                Statistics::increment('user.register');
            }
            catch (PDOException $e)
            {
                throw new Exception('Failed to add the user! Error: ' . $e->getMessage());
            }
        }
        
        public static function updateUser($oldName, $name, $pass, $email, $serveraddr, $apiport, $apipass)
        {
            try
            {
                if (!User::exists($oldName))
                {
                    throw new Exception('User does not exist!', 1);
                };
                if ($oldName != $name && User::exists($name))
                {
                    throw new Exception('User does already exist!', 5);
                }
                
                $db = DatabaseManager::instance()->getDatabase();
                $query = 'UPDATE ' . $db->getPrefix() . 'users SET name=?, password =?, email=?, serveraddress=?, apiport=?, '
                       . 'apipassword=? WHERE name=?';
                $salt = self::getSalt();
                $crypter = self::getCrypter($pass);
                $mailCrypter = self::getCrypter(Config::instance('bukkitweb')->get('encryptionKey'));
                $db->preparedQuery($query, array(
                    substr($name, 0, 40),
                    hash('SHA512', $pass . $salt),
                    $mailCrypter->encrypt($email),
                    $crypter->encrypt($serveraddr),
                    $crypter->encrypt($apiport),
                    $crypter->encrypt($apipass),
                    $oldName
                ), false);
                if (
                    isset($_SESSION['user']) &&
                    $_SESSION['user'] instanceof User &&
                    $_SESSION['user']->getName() == $oldName
                )
                {
                    unset($_SESSION['user']);
                }
            }
            catch (PDOException $e)
            {
                throw new Exception('Failed to update the user! Error: ' . $e->getMessage());
            }
        }
        
        public static function exists($name)
        {
            $db = DatabaseManager::instance()->getDatabase();
            $query = 'SELECT count(*) as count FROM ' . $db->getPrefix() . 'users WHERE name=?';
            $result = $db->preparedQuery($query, array($name));
            return ($result[0]['count'] > 0);
        }
        
        public static function login(User $user)
        {
            $_SESSION['user'] = $user;
        }
        
        public static function logout()
        {
            unset($_SESSION['user']);
                
            // Stats
            Statistics::increment('user.logout');
        }
        
        public static function loggedIn()
        {
            return (isset($_SESSION['user']) && $_SESSION['user'] instanceof User);
        }
        
        protected static function getSalt()
        {
            $salt = Config::instance('bukkitweb')->get('staticSalt');
            if ($salt === null)
            {
                throw new Exception('No static salt specified!', 4);
            }
            return $salt;
        }
        
        protected static function getCrypter($key)
        {
            if ($key === null)
            {
                throw new Exception('No encryption key specified!', 3);
            }
            return new AESCrypter($key, 2);
        }
        
        
        public function serialize()
        {
            $crypter = self::getCrypter(Config::instance('bukkitweb')->get('encryptionKey'));
            $data = serialize($this->userdata);
            return serialize($crypter->encrypt($data));
        }
        
        public function unserialize($serialized)
        {
            $crypter = self::getCrypter(Config::instance('bukkitweb')->get('encryptionKey'));
            $data = unserialize($serialized);
            $userdata = @unserialize($crypter->decrypt($data));
            if ($userdata === false)
            {
                throw new Exception('Decryption seems to have failed due to a wrong encryption key');
            }
            $this->userdata = $userdata;
        }

        public function offsetExists($offset)
        {
            return isset($this->userdata[$offset]);
        }

        public function offsetGet($offset)
        {
            return $this->userdata[$offset];
        }

        public function offsetSet($offset, $value)
        {} //not supported

        public function offsetUnset($offset)
        {} //not supported
    }
?>
