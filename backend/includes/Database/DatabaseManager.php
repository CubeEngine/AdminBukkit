<?php
    class DatabaseManager
    {
        private static $instance = null;
        protected $database;

        private function __construct()
        {
            $dbDriverName = Config::instance('bukkitweb')->get('database', 'MySQL');
            $path = INCLUDE_PATH . DS . 'Database' . DS . 'Drivers' . DS . $dbDriverName . '.php';
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
         *
         * @return IDatabase the loaded database
         */
        public function getDatabase()
        {
            return $this->database;
        }

        public static function instance()
        {
            Logger::instance('database')->write(0, 'info', 'Db Mgr instance requested!');
            if (self::$instance === null)
            {
                self::$instance = new self();
            }
            return self::$instance;
        }
    }
?>
