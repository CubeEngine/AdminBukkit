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
                        $this->members = explode(',', $result['host']);
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
         */
        public static function createServer($alias, $host, $port, $authkey, $owner, array $members = array())
        {
            $db = Yii::app()->db->createCommand()->insert(self::$tableName, array(
                'alias' => $alias,
                'host' => $host,
                'port' => $port,
                'authkey' => $authkey,
                'owner' => User::get($owner)->getId(),
                'members' => implode(',', $members)
            ));
        }

        /**
         * Synchronizes the database entry with the current values
         */
        public function save()
        {
            try
            {
                $this->db->createCommand()->update(
                    self::$tableName,
                    array(
                        'alias' => $this->alias,
                        'host' => $this->host,
                        'port' => $this->port,
                        'authkey' => $this->authkey,
                        'owner' => User::get($this->owner)->getId(),
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
                    $this->owner = User::get($result['owner']);
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
         * @return int the owners ID
         */
        public function getOwner()
        {
            return $this->owner;
        }

        /**
         * Sets the server owner
         *
         * @param User $owner the new server owner
         * @return Server fluent interface
         */
        public function setOwner($owner)
        {
            $userId = null;
            if (is_object($owner) && $owner instanceof User)
            {
                $userId = $owner->getId();
            }
            else
            {
                try
                {
                    $userId = User::get($owner)->getId();
                }
                catch (CException $e)
                {}
            }
            if ($userId !== null)
            {
                $this->owner = $userId;
            }

            return $this;
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
         *
         * @param int[] $members
         * @return Server
         */
        public function setMembers(array $members)
        {
            $this->members = array();
            foreach ($members as $member)
            {
                $user = User::get($member);
                if ($user)
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
            $userId = null;
            if ($user !== null)
            {
                if (is_object($user) && $user instanceof User)
                {
                    $userId = $user->getId();
                }
                else
                {
                    try
                    {
                        $userId = User::get($user)->getId();
                    }
                    catch (CException $e)
                    {}
                }
            }
            if ($userId !== null && !in_array($userId, $this->members))
            {
                $this->members[] = $userId;
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
            $userId = null;
            if ($user !== null)
            {
                if (is_object($user) && $user instanceof User)
                {
                    $userId = $user->getId();
                }
                elseif (is_int($user) || is_numeric($user))
                {
                    $userId = User::get($user)->getId();
                }
            }

            unset($this->members[array_search($userId, $this->members)]);

            return $this;
        }

        /**
         * Removes this server from the database
         *
         * @return Server fluent interface
         */
        public function delete()
        {
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
         * @param Server $server
         * @return bool whether the servers are equal
         */
        public function equals($server)
        {
            return (is_object($server) && ($server instanceof Server) && $this->id === $server->getId());
        }

        public function __toString()
        {
            return $this->alias . '(' . $this->host . ':' . $this->port . ')';
        }
    }
?>
