<?php
    class User implements Serializable
    {
        private static $usersById = array();
        private static $usersByName = array();
        private static $usersByEmail = array();
        private $db;

        private $id;
        private $name;
        private $email;
        private $servers;

        private $currentServer;
        private $loginIp;
        
        private function __construct($id)
        {
            try
            {
                $idField = 'name';
                if (substr_count($id, '@'))
                {
                    $idField = 'email';
                }
                elseif (is_int($id) || is_numeric($id))
                {
                    $id = intval($id);
                    $idField = 'id';
                }
                $this->db = DatabaseManager::instance()->getDatabase();
                $query = 'SELECT id,name,email,servers,currentserver FROM ' . $this->db->getPrefix() . 'users WHERE ' . $idField . '=?';
                $result = $this->db->preparedQuery($query, array($id));
                if (!count($result))
                {
                    throw new Exception('User does not exist!', 1);
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
                    $this->currentServer = Server::get($result['currentserver']);
                }
                catch(Exception $e)
                {
                    $this->currentServer = null;
                }
                $this->loginIp = $_SERVER['REMOTE_ADDR'];
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
        private static function password($pass)
        {
            $salt = Config::instance('bukkitweb')->get('staticSalt');
            if ($salt === null)
            {
                throw new Exception('No static salt specified!', 4);
            }
            return hash('SHA512', $pass . $salt);
        }

        /**
         * Returns the user instance if the given user exists
         *
         * @param String $identifier the user name or ID
         * @return User the user
         */
        public static function get($identifier)
        {
            if (is_numeric($identifier))
            {
                $identifier = intval($identifier);
            }
            $user = null;
            if (isset(self::$usersByEmail[$identifier]))
            {
                $user = self::$usersByEmail[$identifier];
            }
            elseif (isset(self::$usersByName[$identifier]))
            {
                $user = self::$usersByName[$identifier];
            }
            elseif (isset(self::$usersById[$identifier]))
            {
                $user = self::$usersById[$identifier];
            }
            if ($user === null)
            {
                $user = new self($identifier);
                $id = $user->getId();
                self::$usersById[$id] = $user;
                self::$usersByName[$user->getName()] =& self::$usersById[$id];
                self::$usersByEmail[$user->getEmail()] =& self::$usersById[$id];
            }
            return $user;
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
                    self::password($pass),
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

        public function validatePassword($password)
        {
            $query = 'SELECT password FROM ' . $this->db->getPrefix() . 'users WHERE id=?';
            $result = $this->db->preparedQuery($query, array($this->id));
            if (!count($result))
            {
                throw new Exception('User does not exist!', 1);
            }
            $result = $result[0];
            return (self::password($password) !== $result['password']);
        }

        /**
         * Synchronizes the database entry with the current values
         *
         * @return User fluent interface
         */
        public function save()
        {
            $query = 'UPDATE ' . $this->db->getPrefix() . 'users SET name=?, email=?, servers=? WHERE id=?';
            $this->db->preparedQuery($query, array(
                $this->name,
                $this->email,
                implode(',', $this->servers),
                $this->id
            ), false);

            return $this;
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
         * Sets the name
         *
         * @param string $name the new name
         * @return User fluent interface
         */
        public function setName($name)
        {
            $name = substr($name, 0, 40);
            if ($name != $this->name)
            {
                if (!self::exists($name))
                {
                    $this->name;
                }
                else
                {
                    throw new Exception('User does already exist!', 5);
                }
            }
            
            return $this;
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
         * Sets the email address
         *
         * @param string $email the new email address
         * @return User fluent interface
         */
        public function setEmail($email)
        {
            $this->email = substr($email, 0, 100);
            
            return $this;
        }

        /**
         * Returns the IDs of all servers
         *
         * @return int[] the server IDs
         */
        public function getServers()
        {
            return $this->servers;
        }

        /**
         * Sets the server IDs
         *
         * @param int[] $servers the server IDs
         * @return User fluent interface
         */
        public function setServers(array $servers)
        {
            $this->servers = $servers;

            return $this;
        }

        /**
         * Removes all server IDs
         *
         * @return User fluent interface
         */
        public function clearServers()
        {
            $this->servers = array();

            return $this;
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

            return $this;
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

            unset($this->servers[array_search($serverId, $this->servers)]);

            return $this;
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
         * @return User fluent interface
         */
        public function delete()
        {
            $query = 'DELETE FROM ' . $this->db->getPrefix() . 'users WHERE id=? LIMIT 1';
            $this->db->preparedQuery($query, array($this->id));
            unset(self::$usersByEmail[$this->email]);
            unset(self::$usersByName[$this->name]);
            unset(self::$usersById[$this->id]);
            
            return $this;
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
                $this->setName($name)
                     ->setEmail($email)
                     ->setServers($servers);
                
                $query = 'UPDATE ' . $this->db->getPrefix() . 'users SET name=?, password=?, email=?, servers=? WHERE id=?';
                $this->db->preparedQuery($query, array(
                    $this->name,
                    hash('SHA512', $pass . self::password()),
                    $this->email,
                    implode(',', $this->servers),
                    $this->id
                ), false);
            }
            catch (PDOException $e)
            {
                throw new Exception('Failed to update the user! Error: ' . $e->getMessage());
            }
        }

        /**
         * Checks whether a user exists
         *
         * @param mixed $id the user name or id
         * @return bool whether the user exists
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

        /**
         * Loggs this user in
         *
         * @return User fluent interface
         */
        public function login()
        {
            $_SESSION['user'] = $this;

            // Stats
            Statistics::increment('user.login');

            return $this;
        }

        /**
         * Loggs this user out
         *
         * @return User fluent interface
         */
        public function logout()
        {
            unset($_SESSION['user']);
                
            // Stats
            Statistics::increment('user.logout');

            return $this;
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

        /**
         * Returns the user name if this object is used in string context
         *
         * @return string the user name
         */
        public function __toString()
        {
            return $this->name;
        }
    }
?>
