<?php
    class Server implements Serializable
    {
        private static $instances = array();
        private $db;

        private $id;
        private $alias;
        private $host;
        private $port;
        private $authkey;
        private $owner;
        private $members;

        private function __construct($serverId)
        {
            try
            {
                $this->id = $serverId;
                $this->db = DatabaseManager::instance()->getDatabase();
                $result = $this->db->preparedQuery('SELECT id,`alias`,host,port,authkey,owner,members FROM ' . $this->db->getPrefix() . 'servers WHERE id=?', array($serverId));
                if (count($result))
                {
                    $result = $result[0];
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
                    throw new Exception('The requested server was not found!');
                }
            }
            catch (Exception $e)
            {
                throw new Exception('Failed to load the server from database!');
            }
        }

        public static function getInstance($serverId)
        {
            if (!isset(self::$instances[$serverId]))
            {
                self::$instances[$serverId] = new self($serverId);
            }
            return self::$instances[$serverId];
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
            $db = DatabaseManager::instance()->getDatabase();
            $db->preparedQuery('INSERT INTO ' . $db->getPrefix() . 'servers (`alias`,host, port, authkey, owner, members) VALUES (?,?,?,?,?,?)', array(
                $alias,
                $host,
                $port,
                $authkey,
                $owner,
                implode(',', $members)
            ));
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
         * Returns the server's host address
         *
         * @return string the server host
         */
        public function getHost()
        {
            return $this->host;
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
         * Returns the API authkey
         *
         * @return string the API authkey
         */
        public function getAuthKey()
        {
            return $this->authkey;
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
         * Returns the IDs of all members except the owner
         *
         * @return int[] an array of the member IDs
         */
        public function getMembers()
        {
            return $this->members;
        }

        /**
         * Removes this server from the database
         */
        public function delete()
        {
            $this->db->preparedQuery('DELETE FROM ' . $this->db->getPrefix() . 'servers WHERE id=? LIMIT 1', array($this->id));
        }

        /**
         * Updates a server entry
         *
         * @param string $alias the server alias
         * @param string $host the server host address
         * @param int $port the port
         * @param string $authkey the API authkey
         * @param int $owner the owner's ID
         * @param int[] $members the members's IDs
         */
        public function update($alias, $host, $port, $authkey, $owner, array $members)
        {
            $this->db->preparedQuery('UPDATE ' . $this->db->getPrefix() . 'servers SET `alias`=?, host=?, port=?, authkey=?, owner=?, members=? WHERE id=?', array(
                $alias,
                $host,
                $port,
                $authkey,
                $owner,
                implode(',', $members),
                $this->id
            ));
        }

        public function serialize()
        {
            return serialize(array($this->id, $this->alias, $this->host, $this->port, $this->authkey, $this->owner, $this->members));
        }

        public function unserialize($serialized)
        {
            $data = unserialize($serialized);
            $this->id = $data[0];
            $this->alias = $data[1];
            $this->host = $data[2];
            $this->port = $data[3];
            $this->authkey = $data[4];
            $this->owner = $data[5];
            $this->members = $data[6];
        }
    }
?>
