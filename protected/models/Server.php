<?php
    class Server implements Serializable
    {
        private static $tableName = '{{servers}}';

        private static $servers = array();
        private $db;

        private $id;
        private $alias;
        private $host;
        private $port;
        private $authkey;
        private $owner;
        private $members;

        const ERR_NOT_FOUND = 0;

        private function __construct($serverId)
        {
            try
            {
                $this->id = $serverId;
                $this->db = Yii::app()->db;

                $result = $this->db->createCommand()
                        ->select(array('id', 'alias', 'host', 'port', 'authkey', 'owner', 'members'))
                        ->from(self::$tableName)
                        ->where('id = :id', array(':id' => intval($serverId)))
                        ->limit(1)
                            ->query();
                if (count($result))
                {
                    $result = $result->read();
                    $this->id = $result['id'];
                    $this->alias = $result['alias'];
                    $this->host = $result['host'];
                    $this->port = $result['port'];
                    $this->authkey = $result['authkey'];
                    $this->owner = $result['owner'];
                    if ($result['members'])
                    {
                        $this->members = explode(',', $result['members']);
                    }
                    else
                    {
                        $this->members = array();
                    }
                }
                else
                {
                    throw new CModelException('Server not found!', self::ERR_NOT_FOUND);
                }
            }
            catch (Exception $e)
            {
                // @todo handle this different
                throw $e;
                throw new Exception('Failed to load the server from database! Error: ' . $e->getMessage());
            }
        }

        public static function get($id)
        {
            if ($id === null)
            {
                return null;
            }
            if (is_object($id) && $id instanceof Server)
            {
                return $id;
            }
            try
            {
                if (!isset(self::$servers[$id]))
                {
                    self::$servers[$id] = new self($id);
                }
                return self::$servers[$id];
            }
            catch (CModelException $e)
            {
                return null;
            }
        }

        /**
         * Creates a new server entry
         *
         * @param string $alias
         * @param string $host
         * @param int $port
         * @param string $authkey
         * @param int $owner
         * @param int[] $members
         * @return int the ID of the server
         */
        public static function createServer($alias, $host, $port, $authkey, $owner, array $members = array())
        {
            $db = Yii::app()->db;
            $db->createCommand()->insert(self::$tableName, array(
                'alias' => $alias,
                'host' => $host,
                'port' => $port,
                'authkey' => $authkey,
                'owner' => User::get($owner)->getId(),
                'members' => implode(',', $members)
            ));
            return $db->getLastInsertID();
        }

        /**
         * Synchronizes the database entry with the current values
         */
        public function save()
        {
            $owner = User::get($this->owner);
            if ($owner === null)
            {
                throw new CModelException('Can\'t save a server without a valid owner!');
            }
            try
            {
                $this->db->createCommand()->update(
                    self::$tableName,
                    array(
                        'alias' => $this->alias,
                        'host' => $this->host,
                        'port' => $this->port,
                        'authkey' => $this->authkey,
                        'owner' => $owner->getId(),
                        'members' => implode(',', $this->members)
                    ),
                    'id = :id',
                    array(':id' => $this->id)
                );
            }
            catch (CDbException $e)
            {
                // @todo ignore exception
                throw $e;
            }
        }

        /**
         * Refreshes the data from the database
         *
         * @return Server fluent interface
         */
        public function refresh()
        {
            try
            {
                $result = $this->db->createCommand()
                        ->select(array('alias', 'host', 'port', 'authkey', 'owner', 'members'))
                        ->from(self::$tableName)
                        ->where('id = :id', array(':id' => $this->id))
                        ->limit(1)
                            ->query();
                if (count($result))
                {
                    $result = $result->read();
                    $this->alias = $result['alias'];
                    $this->host = $result['host'];
                    $this->port = $result['port'];
                    $this->authkey = $result['authkey'];
                    $this->owner = $result['owner'];
                    if ($result['members'])
                    {
                        $this->members = explode(',', $result['members']);
                    }
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
         * Returns the server's ID
         *
         * @return int the server ID
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Returns the server's alias
         *
         * @return string the server alias
         */
        public function getAlias()
        {
            return $this->alias;
        }

        /**
         * Sets the server alias
         *
         * @param string $alias the new alias
         * @return Server fluent interface
         */
        public function setAlias($alias)
        {
            $this->alias = substr($alias, 0, 30);

            return $this;
        }

        /**
         * Returns the server's host address
         *
         * @return string the server host
         */
        public function getHost()
        {
            return $this->host;
        }

        /**
         * Sets the server host address
         *
         * @param string $host the host address
         * @return Server fluent interface
         */
        public function setHost($host)
        {
            $this->host = substr($host, 0, 100);

            return $this;
        }

        /**
         * Returns the server's port
         *
         * @return int the server port
         */
        public function getPort()
        {
            return $this->port;
        }

        /**
         * Sets the server port
         *
         * @param int $port the new port
         * @return Server fluent interface
         */
        public function setPort($port)
        {
            $port = intval($port);
            if ($port > 0 && $port < 65536)
            {
                $this->port = $port;
            }
            else
            {
                throw new CException('Invalid port given!');
            }

            return $this;
        }

        /**
         * Returns the API authkey
         *
         * @return string the API authkey
         */
        public function getAuthKey()
        {
            return $this->authkey;
        }

        /**
         * Sets the API authkey
         *
         * @param string $authkey the new authkey
         * @return Server fluent interface
         */
        public function setAuthKey($authkey)
        {
            $this->authkey = $authkey;

            return $this;
        }

        /**
         * Returns the server owner's ID
         *
         * @return User the owner
         */
        public function getOwner()
        {
            return User::get($this->owner);
        }

        /**
         * Checks whether the given user is the owner of this server
         *
         * @param User $user
         * @return bool true if the given user is the owner
         */
        public function isOwnedBy(User $user)
        {
            return $user->equals($this->owner);
        }

        /**
         * Checks whether this server has a owner
         *
         * @return bool true if this server has a owner
         */
        public function hasOwner()
        {
            return (User::get($this->owner) !== null);
        }

        /**
         * Sets the server owner
         *
         * @param User $owner the new server owner
         * @return Server fluent interface
         */
        public function setOwner($owner)
        {
            $user = User::get($owner);
            if ($user !== null)
            {
                $currentOwner = User::get($this->owner);
                if (!$user->equals($this->owner))
                {
                    if ($currentOwner !== null)
                    {
                        $currentOwner->removeServer($this);
                    }
                    $this->owner = $user->getId();
                }
            }

            return $this;
        }
        
        /**
         * Checks whether the given user is a member of this server
         *
         * @param mixed $user a user identifier or instance
         * @return bool true if the user is a member of this server
         */
        public function hasMember($user)
        {
            $user = User::get($user);
            if ($user !== null)
            {
                return ($this->isOwnedBy($user) || in_array($user->getId(), $this->members));
            }
            return false;
        }

        /**
         * Returns the IDs of all members except the owner
         *
         * @return int[] an array of the member IDs
         */
        public function getMembers()
        {
            return $this->members;
        }

        /**
         * Resets all members
         *
         * @param int[] $members
         * @return Server
         */
        public function setMembers(array $members)
        {
            $this->clearMembers();
            foreach ($members as $member)
            {
                $user = User::get($member);
                if ($user !== null)
                {
                    $this->members[] = $user->getId();
                }
            }

            return $this;
        }

        /**
         * Removes all members
         *
         * @return Server fluent interface
         */
        public function clearMembers()
        {
            foreach ($this->members as $member)
            {
                $user = User::get($member);
                if ($user !== null)
                {
                    $user->removeServer($this);
                }
            }
            $this->members = array();

            return $this;
        }

        /**
         * Adds a member to this server
         *
         * @param mixed $user the user to add as a member
         * @return Server fluent interface
         */
        public function addMember($user)
        {
            $user = User::get($user);
            if ($user !== null)
            {
                $id = $user->getId();
                if (!$this->isOwnedBy($user) && !$this->hasMember($user))
                {
                    $this->members[] = $id;
                }
            }

            return $this;
        }

        /**
         * Removes a server from this user
         *
         * @param mixed $user the server to remove
         * @return Server fluent interface
         */
        public function removeMember($user)
        {
            $user = User::get($user);
            if ($user !== null)
            {
                if ($this->isOwnedBy($user))
                {
                    $this->owner = null;
                }
                $index = array_search($user->getId(), $this->members);
                if ($index !== false)
                {
                    unset($this->members[$index]);
                }
            }

            return $this;
        }

        /**
         * Removes this server from the database
         *
         * @return Server fluent interface
         */
        public function delete()
        {
            if ($this->hasOwner())
            {
                $this->getOwner()->removeServer($this);
            }
            foreach ($this->members as $member)
            {
                $user = User::get($member);
                if ($user !== null)
                {
                    $user->removeServer($this);
                }
            }
            $this->db->createCommand()->delete(self::$tableName, 'id = :id', array(':id' => $this->id));
            unset(self::$servers[$this->id]);

            return $this;
        }

        /**
         * Serializes this server
         *
         * @return String the serialized object
         */
        public function serialize()
        {
            $this->save();
            return serialize(array($this->id));
        }

        /**
         * Unserializes a serialized Server object
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
         * Checks whether another server equals this one
         *
         * @param mixed $server server id or instance
         * @return bool true if the servers are equal
         */
        public function equals($server)
        {
            $server = self::get($server);
            if ($server !== null)
            {
                return ($this->id === $server->getId());
            }
            return false;
        }

        public function __toString()
        {
            return $this->alias;
        }
    }
?>
