<?php
    class User implements Serializable, IUserIdentity
    {
        private static $tableName = '{{users}}';

        private static $usersById = array();
        private static $usersByName = array();
        private static $usersByEmail = array();
        private $db;

        private $id;
        private $name;
        private $email;
        private $servers;
        
        private $password;

        private $selectedServer;
        private $isAuthenticated;

        private static $current = null;

        const ERR_NOT_FOUND = 1;
        const ERR_WRONG_PASS = 2;
        const ERR_NAME_USED = 3;
        const ERR_EMAIL_USED = 4;
        
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
                    $idField = 'id';
                    $id = intval($id);
                }
                $this->db = Yii::app()->db;
                $result = $this->db->createCommand()
                        ->select(array('id', 'name', 'email', 'servers', 'selectedserver'))
                        ->from(self::$tableName)
                        ->where($idField . ' = :id', array(':id' => $id))
                        ->limit(1)
                            ->query();
                if (!count($result))
                {
                    throw new CModelException('User ' . $id . ' (' . $idField . ') not found!', self::ERR_NOT_FOUND);
                }
                $result = $result->read();

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
                $this->password = null;
                $this->selectedServer = Server::get($result['selectedserver']);
                $this->isAuthenticated = false;
            }
            catch (CDbException $e)
            {
                // @todo handle this different
                throw $e;
                throw new CException("Failed to load the user! Error: " . $e->getMessage(), -1);
            }
        }
        
        private function __clone()
        {}

        /**
         * Returns the salt from the configuration or throws an exception if non is set
         *
         * @return string the salt
         */
        public static function password($pass)
        {
            $salt = null;
            $params = Yii::app()->params;
            if (isset($params['secret']))
            {
                $salt = $params['secret'];
            }
            if ($salt === null)
            {
                throw new CException('No static salt specified!');
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
            if ($identifier === null)
            {
                return null;
            }
            if (is_object($identifier) && $identifier instanceof User)
            {
                return $identifier;
            }
            try
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
            catch (CModelException $e)
            {
                return null;
            }
        }

        /**
         * Sets the current user.
         * This can only be done once!
         *
         * @staticvar boolean $set
         * @param mixed $user user id or instance
         */
        public static function setCurrent($user)
        {
            static $set = false;
            if (!$set)
            {
                self::$current = self::get($user);
                $set = true;
            }
        }

        /**
         * Returns the current user;
         *
         * @return User the curren user
         */
        public static function getCurrent()
        {
            return self::$current;
        }

        /**
         * Creates a new user
         *
         * @param string $name the user name
         * @param string $password the password
         * @param string $email the email address
         * @return User the new user
         */
        public static function createUser($name, $password, $email, array $servers = array(), $stats = true)
        {
            try
            {
                if (User::exists($name))
                {
                    throw new CModelException('Name is already in use!', self::ERR_NAME_USED);
                }
                if (User::exists($email))
                {
                    throw new CModelException('Email is already in use!', self::ERR_EMAIL_USED);
                }

                Yii::app()->db->createCommand()->insert(self::$tableName, array(
                    'name' => $name,
                    'password' => self::password($password),
                    'email' => $email,
                    'servers' => implode(',', $servers)
                ));

                // Stats
                if ($stats)
                {
                    $stat = new Statistic('user.register');
                    $stat->increment();
                }
            }
            catch (CDbException $e)
            {
                // @todo handle this different
                throw $e;
                throw new Exception('Failed to add the user! Error: ' . $e->getMessage());
            }

            return self::get($name);
        }
        
        public static function recreateUser(User $user, $password)
        {
            return self::createUser(
                $user->getName(),
                $password,
                $user->getEmail(),
                $user->getServers(),
                false
            );
        }

        public function authenticate()
        {
            $result = $this->db->createCommand()
                    ->select('password')
                    ->from('users')
                    ->where('id = :id', array(':id' => $this->id))
                    ->limit(1)
                        ->query();
            if (!count($result))
            {
                throw new CModelException('User does not exist!', self::ERR_NOT_FOUND);
            }
            $result = $result->read();
            if ($this->password === $result['password'])
            {
                $this->isAuthenticated = true;
                return true;
            }
            return false;
        }

        public function getIsAuthenticated()
        {
            return $this->isAuthenticated;
        }

        /**
         * Synchronizes the database entry with the current values
         *
         * @return User fluent interface
         */
        public function save()
        {
            $data = array(
                'name' => $this->name,
                'email' => $this->email,
                'servers' => implode(',', $this->servers),
                'selectedserver' => ($this->selectedServer ? $this->selectedServer->getId() : null)
            );
            if ($this->password !== null)
            {
                $data['password'] = $this->password;
                $this->password = null;
            }
            try
            {
                $this->db->createCommand()->update(
                    'users',
                    $data,
                    'id = :id',
                    array(':id' => $this->id)
                );
            }
            catch (CDbException $e)
            {
                // @todo ignore exception
                throw $e;
            }

            return $this;
        }

        /**
         * Refreshes the data from the database
         *
         * @return User fluent interface
         */
        public function refresh()
        {
            try
            {
                $result = $this->db->createCommand()
                        ->select(array('name', 'email', 'servers', 'selectedserver'))
                        ->from('users')
                        ->where('id = :id', array(':id' => $this->id))
                        ->limit(1)
                            ->query();
                if (count($result))
                {
                    $result = $result->read();
                    $this->name = $result['name'];
                    $this->email = $result['email'];
                    if ($result['servers'])
                    {
                        $this->servers = explode(',', $result['servers']);
                    }
                    $this->selectedServer = Server::get($result['selectedserver']);
                }
            }
            catch (CDbException $e)
            {
                // @todo ignore exception
                throw $e;
            }

            return $this;
        }
        
        /**
         * Sets the password for authentication and change
         *
         * @param stirng $password the password to set
         * @return User fluet interface
         */
        public function setPassword($password)
        {
            $this->password = self::password($password);
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
                    unset(self::$usersByName[$this->name]);
                    $this->name = $name;
                    self::$usersByName[$this->name] =& self::$usersById[$this->id];
                }
                else
                {
                    throw new CModelException('User name already in use!', self::ERR_NAME_USED);
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
            $email = substr($email, 0, 100);
            if ($email != $this->email)
            {
                if (!self::exists($email))
                {
                    unset(self::$usersByEmail[$this->email]);
                    $this->email = $email;
                    self::$usersByEmail[$this->email] =& self::$usersById[$this->id];
                }
                else
                {
                    throw new CModelException('Email address already in use!', self::ERR_EMAIL_USED);
                }
            }
            
            return $this;
        }
        
        /**
         * Gets a server from the user
         *
         * @param int $serverId the server to get
         * @return Server the server
         */
        public function getServer($server)
        {
            $server = Server::get($server);
            if ($this->hasServer($server))
            {
                return $server;
            }
            return null;
        }
        
        /**
         * Checks whether the suer is a member of the given server
         *
         * @param mixed $server a server id or instance
         * @return bool true if the user is a member of the given server
         */
        public function hasServer($server)
        {
            $server = Server::get($server);
            if ($server !== null)
            {
                return in_array($server->getId(), $this->servers);
            }
            return false;
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
            $this->servers = array();
            foreach ($servers as $server)
            {
                $server = Server::get($server);
                if ($server !== null)
                {
                    $this->servers[] = $server->getId();
                }
            }
            
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
            $server = Server::get($server);
            if ($server !== null)
            {
                $id = $server->getId();
                if (!$server->hasMember($this))
                {
                    $server->addMember($this);
                }
                if (!$this->hasServer($server))
                {
                    $this->servers[] = $id;
                }
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
            $server = $server = Server::get($server);
            $serverId = null;
            if ($server)
            {
                $serverId = $server->getId();
            }

            if ($serverId !== null)
            {
                $index = array_search($serverId, $this->servers);
                if ($index !== false)
                {
                    unset($this->servers[$index]);
                }
            }

            return $this;
        }

        /**
         * Returns the currently selected server
         *
         * @return Server the currently selected server
         */
        public function getSelectedServer()
        {
            return $this->selectedServer;
        }

        /**
         * Sets the currently selected server
         *
         * @param Server $server the server to set
         * @return User fluent interface
         */
        public function setSelectedServer(Server $server)
        {
            $this->selectedServer = $server;
            return $this;
        }

        /**
         * Returns the IP the user logged in with
         *
         * @return string the IP
         */
        public function getLoginIp()
        {
            return Yii::app()->user->getState('loginip');
        }

        /**
         * Sets the login IP
         *
         * @return User fluent interface
         */
        public function setLoginIp()
        {
            if ($this->getLoginIp() === null)
            {
                Yii::app()->user->getState('loginip', Yii::app()->request->getUserHostAddress());
            }
            return $this;
        }

        /**
         * Deleted the user from the database
         *
         * @return User fluent interface
         */
        public function delete()
        {
            foreach ($this->servers as $server)
            {
                $server = Server::get($server);
                if ($server != null)
                {
                    $server->removeMember($this);
                }
            }
            $this->db->createCommand()->delete('users', 'id = :id', array(':id' => $this->id));
            unset(self::$usersByEmail[$this->email]);
            unset(self::$usersByName[$this->name]);
            unset(self::$usersById[$this->id]);
            
            return $this;
        }

        /**
         * Checks whether a user exists
         *
         * @param mixed $id the user name or id
         * @return bool whether the user exists
         */
        public static function exists($id)
        {
            $field = 'name';
            if (substr_count($id, '@'))
            {
                $field = 'email';
            }
            elseif (is_int($id) || is_numeric($id))
            {
                $field = 'id';
            }
            $result = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('users')
                    ->where($field . ' = :id', array(':id' => $id))
                    ->limit(1)
                        ->query();
            return (count($result) > 0);
        }

        /**
         * Serializes this user
         *
         * @return String the serialized object
         */
        public function serialize()
        {
            $this->save();
            return serialize(array($this->id));
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
            $this->refresh();
        }

        /**
         * Checks whether another user equals this one
         *
         * @param User $user
         * @return bool whether the users are equal
         */
        public function equals($user)
        {
            $user = self::get($user);
            if ($user !== null)
            {
                return ($this->id === $user->getId());
            }
            return false;
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

        public function getPersistentStates()
        {
            return array('id' => $this->id);
        }

        /**
         * Logs the given user in.
         *
         * @param mixed $user the users identifier or a User instance
         * @return User the logged in user
         */
        public static function loginUser($user)
        {
            $user = self::get($user);
            if ($user !== null)
            {
                $user->login();
            }
            return $user;
        }

        /**
         * Logs the user in.
         * This depends on the Yii Framework!
         *
         * @return User fluent interface
         */
        public function login()
        {
            Yii::app()->user->login($this);
            $this->setLoginIp();
            return $this;
        }

        /**
         * Logs the user out.
         * This depends on the Yii Framework!
         *
         * @return User fluent interface
         */
        public static function logout()
        {
            Yii::app()->user->logout();
            Yii::app()->user->setState('loginip', null);
            return $this;
        }
    }
?>
