<?php
    class Route
    {
        private $controller;
        private $params;

        public function __construct($controller, array $params)
        {
            $this->controller = $controller;
            $this->params = $params;
        }

        public function getController()
        {
            return $this->controller;
        }

        public function getParam($name, $default = null)
        {
            if (isset($this->params[$name]))
            {
                return $this->params[$name];
            }
            return $default;
        }
    }
?>
