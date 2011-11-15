<?php
    abstract class AppConfig
    {
        protected $paths;
        protected $config;

        public final function getPath($name)
        {
            if (isset($this->paths[$name]))
            {
                return $this->paths[$name];
            }
            return null;
        }

        public final function getConfig()
        {
            return $this->config;
        }
        
        abstract public function initialize();
    }
?>
