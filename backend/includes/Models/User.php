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
                $query = 'SELECT id,name,email,password,servers,currentserver FROM ' . $this->db->getPrefix() . 'users WHERE name=?';
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
                try
                {
                    $this->currentServer = Server::get($result);
                }
                catch(Exception $e)
                {
                    $this->currentServer = null;
                }
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

        /**
         * Returns the salt from the configuration or throws an exception if non is set
         *
         * @return string the salt
         */
        private static function getSalt()
        {
            $salt = Config::instance('bukkitweb')->get('staticSalt');
            if ($salt === null)
            {
                throw new Exception('No static salt specified!', 4);
            }
            return $salt;
        }

        /**
         * Returns the user instance if the given user exists
         *
         * @param String $username the user name
         * @param String $password the user password
         * @return User the user
         */
        public static function get($username, $password = '')
        {
            if (!isset(self::$users[$username]))
            {
                self::$users[$username] = new self($username, $password);
            }
            return self::$users[$username];
        }

        /**
         * Creates a new user
         *
         * @param string $name the user name
         * @param string $pass the password
         * @param string $email the email address
         */
        public static function createUser($name, $pass, $email)
        {
            try
            {
                if (User::exists($name))
                {
                    throw new Exception('User does already exist!', 5);
                }

                $db = DatabaseManager::instance()->getDatabase();
                $query = 'INSERT INTO ' . $db->getPrefix() . 'users (name, password, email) VALUES (?, ?, ?)';
                $db->preparedQuery($query, array(
                    substr($name, 0, 40),
                    hash('SHA512', $pass . self::getSalt()),
                    $email
                ), false);

                // Stats
                Statistics::increment('user.register');
            }
            catch (PDOException $e)
            {
                throw new Exception('Failed to add the user! Error: ' . $e->getMessage());
            }
        }

        /**
         * Synchronizes the database entry with the current values
         */
        public function syncToDatabase()
        {
            $query = 'UPDATE ' . $this->db->getPrefix() . 'users SET name=?, email=?, servers=? WHERE id=?';
            $this->db->preparedQuery($query, array(
                substr($this->name, 0, 40),
                $this->email,
                implode(',', $this->servers),
                $this->id
            ), false);
        }

        /**
         * Returns the user's ID
         *
         * @return int the user ID
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Returns the user's name
         *
         * @return String the user name
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * Returns the user's email address
         *
         * @return String the user email address
         */
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

        /**
         * Returns the IP the user logged in with
         *
         * @return string the IP
         */
        public function getLoginIp()
        {
            return $this->loginIp;
        }

        /**
         * Deleted the user from the database
         *
         * @return bool whether the operation succeeded
         */
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

        /**
         * Updates the user information
         *
         * @param string $name the new user name
         * @param string $pass the new password
         * @param string $email the new email address
         * @param int[] $servers the new servers
         */
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
                $this->db->preparedQuery($query, array(
                    substr($name, 0, 40),
                    hash('SHA512', $pass . self::getSalt()),
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

        /**
         * Adds a server to this user
         *
         * @param mixed $server the server to add
         */
        public function addServer($server)
        {
            $serverId = null;
            if ($server !== null)
            {
                if (is_object($server) && $server instanceof Server)
                {
                    $serverId = $server->getId();
                }
                elseif (is_int($server) || is_numeric($server))
                {
                    $server = intval($server);
                    if ($server >= 0)
                    {
                        $serverId = $server;
                    }
                }
            }
            if ($serverId !== null && !in_array($serverId, $this->servers))
            {
                $this->servers[] = $serverId;
            }

            $this->syncToDatabase();
        }

        /**
         * Removes a server from this user
         *
         * @param mixed $server the server to remove
         */
        public function removeServer($server)
        {
            $serverId = null;
            if ($server !== null)
            {
                if (is_object($server) && $server instanceof Server)
                {
                    $serverId = $server->getId();
                }
                elseif (is_int($server) || is_numeric($server))
                {
                    $server = intval($server);
                    if ($server >= 0)
                    {
                        $serverId = $server;
                    }
                }
            }

            foreach ($this->servers as $index => $id)
            {
                if ($id == $serverId)
                {
                    unset($this->servers[$index]);
                }
            }

            $this->syncToDatabase();
        }

        /**
         *
         * @param type $id
         * @return type
         */
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

        /**
         * Serializes this user
         *
         * @return String the serialized object
         */
        public function serialize()
        {
            return serialize(array($this->id, $this->name, $this->email, $this->servers, $this->currentServer->getId(), $this->loginIp));
        }

        /**
         * Unserializes a serialized User object
         *
         * @param String $serialized the serialized object
         */
        public function unserialize($serialized)
        {
            $data = unserialize($serialized);
            $this->id = $data[0];
            $this->name = $data[1];
            $this->email = $data[2];
            $this->servers = $data[3];
            try
            {
                $this->currentServer = Server::get($data[4]);
            }
            catch (Exception $e)
            {
                $this->currentServer = null;
            }
            $this->loginIp = $data[5];
        }

        /**
         * Checks whether another user equals this one
         *
         * @param User $user
         * @return bool whether the users are equal
         */
        public function equals($user)
        {
            return (is_object($user) && ($user instanceof User) && $this->id === $user->getId());
        }
    }
?>
