<?php
    import('Util.Configuration.FileConfiguration');
    import('Util.Configuration.ConfigurationException');
    import('Text.Crypter.AESCrypter');

    /**
     *
     */
    class EncryptedCFileConfiguration implements FileConfiguration
    {
        public static $configs = array();
        protected $activConfig;
        protected $crypter;
        protected $filepath;
        protected $privatekey;

        public function __construct($filepath, $privatekey)
        {
            $this->filepath = $filepath;
            $this->privatekey = $privatekey;
            list($this->activConfig, $this->crypter) = $this->load();
        }

        public function load($reload = false)
        {
            if (!isset(self::$configs[$this->filepath]) || $reload)
            {
                $crypter = new AESCrypter($this->privatekey, 1);

                if (!is_readable($this->filepath))
                {
                    return array(array(), $crypter);
                }

                $tmp = @file_get_contents($this->filepath);
                if ($tmp === false)
                {
                    throw new ConfigurationException('The config file exists, but could not be loaded!', 401);
                }

                $tmp = $crypter->decrypt($tmp);

                $tmp = @unserialize($tmp);
                if ($tmp === false || !is_array($tmp))
                {
                    throw new ConfigurationException('A invalid config file was given or the given private key was invalid', 402);
                }
                return array($tmp, $crypter);
            }
            else
            {
                return self::$configs[$filepath];
            }
        }

        public function save()
        {
            if (!is_writable($this->filepath))
            {
                throw new ConfigurationException('The config file is not writable!', 403);
            }
            $tmp = serialize($this->activConfig);
            $tmp = $this->crypter->encrypt($tmp);
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
