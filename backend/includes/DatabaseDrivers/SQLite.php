<?php

    class SQLite extends Database
    {
        protected $connected;
        
        const INIT_SQL = 'CREATE TABLE "users" (
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

        public function __construct()
        {
            $this->connected = false;
            $this->error = '';
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

                try
                {
                    $this->db = new PDO('sqlite:' . $path, 0766, $this->error);
                }
                catch (PDOException $e)
                {
                    throw new Exception('Failed to connect to the database!');
                }
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connected = true;
            }
            if ($init)
            {
                if (!$this->query(self::INIT_SQL, false))
                {
                    throw new Exception('Failed to initialize the database structure!');
                }
            }
        }
        
        public function getPrefix()
        {
            return '';
        }
    }

?>
