<?php
    error_reporting(-1);

    defined('DS')       or define('DS',         DIRECTORY_SEPARATOR);
    defined('SYS_PATH') or define('SYS_PATH',   dirname(__FILE__));
    defined('LIB_PATH') or define('LIB_PATH',   SYS_PATH . DS . 'lib');

    function import($path)
    {
        require_once LIB_PATH . DS . str_replace('.', DS, $path) . '.php';
    }
?>
