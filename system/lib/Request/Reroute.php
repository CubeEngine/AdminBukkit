<?php
    final class Reroute extends Exception
    {
        private $module;
        private $route;

        public function __construct($module, Route $route = null)
        {
            $this->module = $module;
            $this->route = $route;
        }

        public function getModule()
        {
            return $this->module;
        }

        public function getRoute()
        {
            return $this->route;
        }
    }
?>
