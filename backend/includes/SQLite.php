<?php

    class SQLite
    {
        private static $instance;
        
        protected $db;
        protected $error;
        protected $connected;
        
        protected static $INIT_SQL = 'CREATE TABLE "users" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "name" text(40) COLLATE \'NOCASE\' NOT NULL,
  "email" text(500) NOT NULL,
  "password" text(129) NOT NULL,
  "serveraddress" text(500) NOT NULL,
  "apiport" text(500) NOT NULL,
  "apipassword" text(500) NOT NULL
);
CREATE TABLE "statistics" (
  "index" text(50) NOT NULL PRIMARY KEY,
  "value" integer NOT NULL
);
CREATE TABLE "servers" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "uid" integer NOT NULL,
  "serverdata" text NOT NULL
)';

        private function __construct()
        {
            $this->connected = false;
            $this->error = '';
        }
        
        private function __clone()
        {}
        
        /**
         *
         * @return SQLite the database instance 
         */
        public static function instance()
        {
            if (self::$instance === null)
            {
                self::$instance = new self();
            }
            return self::$instance;
        }
        
        public function connect()
        {
            $init = false;
            if (!$this->connected)
            {
                $path = Config::instance('bukkitweb')->get('databaseDir', '.') . DS . 'users.db';
                $dir = dirname($path);
                if (!file_exists($path))
                {
                    if (!is_writable($dir))
                    {
                        throw new Exception('Could not create the database, path not writable!');
                    }
                    $init = true;
                }
                
                $this->db = new PDO('sqlite:' . $path, 0766, $this->error);
                if ($this->db === false)
                {
                    throw new Exception('Failed to connect to the database!');
                }
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connected = true;
            }
            if ($init)
            {
                if (!$this->query(self::$INIT_SQL, false))
                {
                    throw new Exception('Failed to initialize the database structure!');
                }
            }
        }
        
        public function preparedQuery($query, array $data, $return = true)
        {
            $this->connect();
            
            $statement = $this->db->prepare($query);
            $statement->execute($data);
            if ($return)
            {
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        
        public function query($query, $return = true)
        {
            $this->connect();
            
            if ($return)
            {
                $result = $this->db->query($query);
                if ($result === false)
                {
                    throw new Exception('The query failed!');
                }
                $fetchedResult = array();
                foreach ($result as $row)
                {
                    $fetchedResult[] = $row;
                }
                
                return $fetchedResult;
            }
            else
            {
                return ($this->db->exec($query) !== false);
            }
        }
        
        public function error()
        {
            return $this->error;
        }
    }

?>
