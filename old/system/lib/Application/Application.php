<?php
    import('Application.AppException');
    import('Application.AppConfig');

    final class Application
    {
        private static $config = null;

        protected $paths;
        
        public function __construct()
        {
            throw new AppException('Access denied');
        }

        private function __clone()
        {}

        public static function initalize($appname)
        {
            if (self::$config === null)
            {
                if ($appname !== null)
                {
                    $configClass = $appname . 'Config';
                    $configPath = APP_PATH . DS . $configClass . '.php';
                    if (is_readable($configPath))
                    {
                        require_once $configPath;
                        if (class_exists($configClass))
                        {
                            $configInstance = new $configClass();
                            if ($configInstance instanceof AppConfig)
                            {
                                $configInstance->initialize();
                                self::$config = $configInstance;
                            }
                            else
                            {
                                throw new AppException('Configs have to extend AppConfig!');
                            }
                        }
                        else
                        {
                            throw new AppException('Invalid config!');
                        }
                    }
                    else
                    {
                        throw new AppException('Config not found or not readable!');
                    }
                }
            }
            else
            {
                throw new AppException('App already initalized');
            }
        }

        public static function getPath($name)
        {
            if (self::$config)
            {
                return self::$config->getPath($name);
            }
        }

        public static function getConfig()
        {
            if (self::$config)
            {
                return self::$config->getConfig();
            }
        }
    }
?>
