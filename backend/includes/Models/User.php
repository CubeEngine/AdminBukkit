<?php
    class User implements Serializable
    {
        private static $users = array();
        private $db;

        private $id;
        private $name;
        private $email;
        private $servers;

        private $currentServer;
        private $loginIp;
        
        private function __construct($name, $password)
        {
            try
            {
                $this->db = DatabaseManager::instance()->getDatabase();
                $query = 'SELECT id,name,email,password,servers FROM ' . $this->db->getPrefix() . 'users WHERE name=?';
                $result = $this->db->preparedQuery($query, array($name));
                if (!count($result))
                {
                    throw new Exception('User does not exist!', 1);
                }
                $result = $result[0];
                $salt = self::getSalt();
                if (hash('SHA512', $password . $salt) !== $result['password'])
                {
                    throw new Exception('Invalid password!', 2);
                }

                $this->id = $result['id'];
                $this->name = $result['name'];
                $this->email = $result['email'];
                if ($result['servers'])
                {
                    $this->servers = explode(',', $result['servers']);
                }
                else
                {
                    $this->servers = array();
                }
                $this->currentServer = null;
                $this->loginIp = $_SERVER['REMOTE_ADDR'];
                
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

        public function getId()
        {
            return $this->id;
        }
        
        public function getName()
        {
            return $this->name;
        }
        
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Returns the currently selected server
         *
         * @return Server the currently selected server
         */
        public function getCurrentServer()
        {
            return $this->currentServer;
        }

        /**
         * Sets the currently selected server
         *
         * @param Server $server the server to set
         * @return User fluent interface
         */
        public function setCurrentServer(Server $server)
        {
            $this->currentServer = $server;
            return $this;
        }

        public function getLoginIp()
        {
            return $this->loginIp;
        }
        
        public function delete()
        {
            try
            {
                $query = 'DELETE FROM ' . $this->db->getPrefix() . 'users WHERE name=? LIMIT 1';
                $this->db->preparedQuery($query, array($this->name));
                return true;
            }
            catch (PDOException $e)
            {
                return false;
            }
        }
        
        
        public static function createUser($name, $pass, $email, $serveraddr, $apiport, $apipass)
        {
            try
            {
                if (User::exists($name))
                {
                    throw new Exception('User does already exist!', 5);
                }
                
                $db = DatabaseManager::instance()->getDatabase();
                $query = 'INSERT INTO ' . $db->getPrefix() . 'users (name, password, email, serveraddress, apiport, apipassword) VALUES (?, ?, ?, ?, ?, ?)';
                $salt = self::getSalt();
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
        
        public function update($name, $pass, $email, array $servers)
        {
            try
            {
                /*
                 * @todo obsolete?
                 *
                if (!User::exists($oldName))
                {
                    throw new Exception('User does not exist!', 1);
                }
                 */
                if ($this->name != $name && User::exists($name))
                {
                    throw new Exception('User does already exist!', 5);
                }
                
                $query = 'UPDATE ' . $this->db->getPrefix() . 'users SET name=?, password=?, email=?, servers=? WHERE id=?';
                $salt = self::getSalt();
                $this->db->preparedQuery($query, array(
                    substr($name, 0, 40),
                    hash('SHA512', $pass . $salt),
                    $email,
                    implode(',', $servers),
                    $this->id
                ), false);
                $this->name = $name;
                $this->email = $email;
                $this->servers = $servers;
                /*
                 * @todo obsolete?
                 *
                if (
                    isset($_SESSION['user']) &&
                    $_SESSION['user'] instanceof User &&
                    $_SESSION['user']->getName() == $oldName
                )
                {
                    unset($_SESSION['user']);
                }
                 */
            }
            catch (PDOException $e)
            {
                throw new Exception('Failed to update the user! Error: ' . $e->getMessage());
            }
        }
        
        public static function exists($id)
        {
            $field = 'id';
            if (is_string($id))
            {
                $field = 'name';
            }
            $db = DatabaseManager::instance()->getDatabase();
            $query = 'SELECT count(*) as count FROM ' . $db->getPrefix() . 'users WHERE ' . $field . '=?';
            $result = $db->preparedQuery($query, array($id));
            return ($result[0]['count'] > 0);
        }
        
        public function login()
        {
            $_SESSION['user'] = $this;
        }
        
        public function logout()
        {
            unset($_SESSION['user']);
                
            // Stats
            Statistics::increment('user.logout');
        }
        
        public function loggedIn()
        {
            return $this->equals($_SESSION['user']);
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
        
        public function serialize()
        {
            return serialize(array($this->id, $this->name, $this->email, $this->servers, $this->currentServer, $this->loginIp));
        }
        
        public function unserialize($serialized)
        {
            $data = unserialize($serialized);
            $this->id = $data[0];
            $this->name = $data[1];
            $this->email = $data[2];
            $this->servers = $data[3];
            $this->currentServer = $data[4];
            $this->loginIp = $data[5];
        }

        public function equals($user)
        {
            return (is_object($user) && ($user instanceof User) && $this->id === $user->getId());
        }
    }
?>
