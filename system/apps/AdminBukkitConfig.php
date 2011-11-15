<?php
    import('Util.Configuration.INIFileConfiguration');
    import('Debug.Debug');
    import('Models.Session');
    
    class AdminBukkitConfig extends AppConfig
    {
        public function __construct()
        {
            $this->paths = array(
                'modules'   => SYS_PATH . DS . 'pages',
                'logs'      => SYS_PATH . DS . 'logs',
                'locales'   => SYS_PATH . DS . 'language',
                'downloads' => SYS_PATH . DS . 'downloads',
                'configs'   => SYS_PATH . DS . 'configs',
                'templates' => SYS_PATH . DS . 'templates',
            );

            Registry::set('debug.printErrors', true);
            
            $this->config = new INIFileConfiguration($this->getPath('configs') . DS . 'main.ini');
        }

        public function initialize()
        {
            set_error_handler(array('Debug', 'error_handler'), -1);
            set_exception_handler(array('Debug', 'exception_handler'));
            register_shutdown_function(array('Debug', 'fatalerror_handler'));
            
            $this->config->load();
            date_default_timezone_set($this->config->get('timezone', 'Europe/Berlin'));
            Logger::setLogLevel($this->config->get('logLevel', 0));
            Session::setName($this->config->get('sessionName', 'sid'));
            Session::setLifetime($this->config->get('sessionCookieLiftime', 3600));
        }
    }
?>
