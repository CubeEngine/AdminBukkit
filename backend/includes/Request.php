<?php
    class Request
    {
        public static function rqst($name, $default = '')
        {
            if (isset($_REQUEST[$name]))
            {
                return $_REQUEST[$name];
            }
            else
            {
                return $default;
            }
        }
        
        public static function get($name, $default = '')
        {
            if (isset($_GET[$name]))
            {
                return $_GET[$name];
            }
            else
            {
                return $default;
            }
        }
        
        public static function post($name, $default = '')
        {
            if (isset($_POST[$name]))
            {
                return $_POST[$name];
            }
            else
            {
                return $default;
            }
        }
        
        public static function cookie($name, $default = '')
        {
            if (isset($_COOKIE[$name]))
            {
                return $_COOKIE[$name];
            }
            else
            {
                return $default;
            }
        }
        
        public static function session($name, $default = '')
        {
            if (isset($_SESSION[$name]))
            {
                return $_SESSION[$name];
            }
            else
            {
                return $default;
            }
        }
    }
?>
