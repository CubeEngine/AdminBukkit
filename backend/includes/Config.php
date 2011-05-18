<?php
    class Config
    {
        protected $config;
        private static $configs = array();
        
        private function __construct($name)
        {
            $path = CONFIG_PATH . DS . $name . '.conf.php';
            if (is_readable($path))
            {
                $config = include $path;
                if (is_array($config))
                {
                    $this->config = $config;
                }
                else
                {
                    throw new Exception('The given config is not valid!');
                }
            }
            else
            {
                throw new Exception('The given config is not readable or does not exist!');
            }
        }
        
        private function __clone()
        {}
        
        public static function instance($name)
        {
            if (!isset(self::$configs[$name]))
            {
                self::$configs[$name] = new self($name);
            }
            return self::$configs[$name];
        }
        
        public function exists($name)
        {
            return isset($this->config[$name]);
        }
        
        public function get($name, $default = null)
        {
            if ($this->exists($name))
            {
                return $this->config[$name];
            }
            else
            {
                return $default;
            }
        }
    }
?>
