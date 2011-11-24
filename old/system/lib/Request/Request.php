<?php
    //import('Models.ModelException');

    /**
     *
     */
    class Request
    {
        private $module;
        private $requestUri;
        private $requestVars;
        
        private $routeSeparator;
        private $routeSections;


        public function __construct()
        {
            $this->requestVars = array();
            $this->requestVars['get'] = $_GET;
            $this->requestVars['post'] = $_POST;
            $this->requestVars['cookie'] = $_COOKIE;
            $this->requestVars['files'] = $_FILES;
            
            $this->routeSeparator = Application::getConfig()->get('getRouteSeparator', '/');
            $this->routeSections = array();

            $this->requestUri = $_SERVER['REQUEST_URI'];
            if (isset($_SERVER['PATH_INFO']))
            {
                $this->routeSections = explode($this->routeSeparator, trim($_SERVER['PATH_INFO'], $this->routeSeparator));
            }
            if (count($this->routeSections))
            {
                $this->module = ucfirst(strtolower($this->routeSections[0]));
            }
            else
            {
                $this->module = 'Index'; // @todo configurable?
            }
            
        }

        public function getModule()
        {
            return $this->module;
        }

        public function getRouteSections()
        {
            return $this->routeSections;
        }

        public function get($type, $name)
        {
            $type = mb_strtolower($type);
            if ($this->exists($type, $name))
            {
                return $this->requestVars[$type][$name];
            }
            else
            {
                return null;
            }
        }

        public function getAll($type)
        {
            if (isset($this->requestVars[$type]))
            {
                return $this->requestVars[$type];
            }
            else
            {
                return null;
            }

        }

        public function exists($type, $name)
        {
            return isset($this->requestVars[$type][$name]);
        }


        public function getRequestUri()
        {
            return $this->requestUri;
        }
    }
    
?>
