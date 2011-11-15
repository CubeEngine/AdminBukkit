<?php
    import('Util.Registry');
    import('Database.DatabaseException');

    class MySQL extends Database
    {
        protected $host;
        protected $port;
        protected $database;
        protected $user;
        protected $pass;
        protected $prefix;

        protected $connected;

        protected $INIT_SQL = 'SET CHARACTER SET \'utf8\';
CREATE TABLE IF NOT EXISTS `__PREFIX__users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(129) NOT NULL,
  `serveraddress` varchar(500) NOT NULL,
  `apiport` varchar(500) NOT NULL,
  `apipassword` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `__PREFIX__statistics` (
  `index` varchar(50) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;';

        public function __construct()
        {
            $config = Application::getConfig();
            if (!$config)
            {
                throw new DatabaseException("No configuration available");
            }

            $this->host = $config->get('mysql_host', 'localhost');
            $this->port = $config->get('mysql_port', 3306);
            $this->database = $config->get('mysql_database', 'adminbukkit');
            $this->user = $config->get('mysql_user', 'root');
            $this->pass = $config->get('mysql_pass', '');
            $this->prefix = $config->get('mysql_prefix', 'ab01_');

            $this->INIT_SQL = str_replace('__PREFIX__', $this->prefix, $this->INIT_SQL);

            $this->connected = false;
        }

        public function connect()
        {
            if (!$this->connected)
            {
                try
                {
                    $this->db = new PDO('mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->database, $this->user, $this->pass);
                }
                catch (PDOException $e)
                {
                    throw new Exception('Failed to connect to the database!');
                }
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connected = true;
                //$this->query($this->INIT_SQL, false);
            }
        }
        
        public function getPrefix()
        {
            return $this->prefix;
        }
    }
?>
