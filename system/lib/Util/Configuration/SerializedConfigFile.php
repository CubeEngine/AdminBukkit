<?php
    import('Util.Configuration.FileConfiguration');
    import('Util.Configuration.ConfigurationException');
    
    /**
     *
     */
    class SerializedConfiguration implements FileConfiguration
    {
        public static $configs = array();
        protected $activConfig;
        protected $filepath;

        public function __construct($filepath)
        {
            $this->filepath = $filepath;
            $this->activConfig = $this->load();
        }

        public function load($reload = false)
        {
            if (!isset(self::$configs[$this->filepath]) || $reload)
            {
                if (!is_readable($this->filepath))
                {
                    return array();
                }

                $tmp = @file_get_contents($this->filepath);
                if ($tmp === false)
                {
                    throw new ConfigurationException('The config file exists, but could not be loaded!', 401);
                }
                
                $tmp = @unserialize($tmp);
                if ($tmp === false || !is_array($tmp))
                {
                    throw new ConfigurationException('A invalid config file was given!', 402);
                }
                return $tmp;
            }
            else
            {
                return self::$configs[$this->filepath];
            }
        }

        public function save()
        {
            if (!is_writable($this->filepath))
            {
                throw new ConfigurationException('The config file is not writable!', 403);
            }

            $tmp = serialize($this->activConfig);
            file_put_contents($this->filepath, $tmp);
        }

        public function get($name, $default = null)
        {
            if ($this->exists($name))
            {
                return $this->activConfig[$name];
            }
            else
            {
                return $default;
            }
        }

        public function set($name, $value, $dontoverwrite = false)
        {
            if (!$dontoverwrite)
            {
                $this->activConfig[$name] = $value;
                return true;
            }
            else
            {
                if (!$this->exists($name))
                {
                    $this->activConfig[$name] = $value;
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }

        public function setMultiple(array $data)
        {
            foreach ($data as $name => $value)
            {
                $this->activConfig[$name] = $value;
            }
        }

        public function setConfig(array $config)
        {
            $this->activConfig = $config;
        }

        public function getAll()
        {
            return $this->activConfig;
        }

        public function exists($name)
        {
            return isset($this->activConfig[$name]);
        }
    }
?>
