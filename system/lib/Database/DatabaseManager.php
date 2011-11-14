<?php
    import('Database.Database');
    import('Database.DatabaseException');
    import('Debug.Logger');
    import('Util.Registry');

    class DatabaseManager
    {
        private static $instance = null;
        protected $database;

        private function __construct()
        {
            $config = Registry::get('config');
            $dbDriverName = 'MySQL';
            if ($config)
            {
                $dbDriverName = $config->get('database', $dbDriverName);
            }
            $path = dirname(__FILE__) . DS . 'Drivers' . DS . $dbDriverName . '.php';
            if (is_readable($path))
            {
                require_once $path;
                if (class_exists($dbDriverName))
                {
                    $dbDriver = new $dbDriverName();
                    if ($dbDriver instanceof Database)
                    {
                        Logger::instance('database')->write(2, 'info', 'Selected database driver "' . $dbDriverName . '"');
                        $this->database = $dbDriver;
                    }
                    else
                    {
                        throw new DatabaseException('The given driver is not compatible');
                    }
                }
                else
                {
                    throw new DatabaseException('The given driver is invalid!');
                }
            }
            else
            {
                throw new DatabaseException('The given driver does not exist or is not readable!');
            }
        }

        private function __clone()
        {}

        /**
         * Returns the currently loaded database
         *
         * @return Database the loaded database
         */
        public function getDatabase()
        {
            return $this->database;
        }

        /**
         * Returns the singleton instance of the DatabaseManager
         *
         * @return DatabaseManager instance of DatabaseManager
         */
        public static function instance()
        {
            if (self::$instance === null)
            {
                self::$instance = new self();
            }
            return self::$instance;
        }
    }
?>
