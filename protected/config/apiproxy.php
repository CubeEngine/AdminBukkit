<?php
    $config = require dirname(__FILE__) . '/main.php';
    $config['defaultController'] = 'apiproxy';
    $config['components']['errorHandler']['errorAction'] = 'apiproxy/handle';

    unset($config['components']['urlManager']);

    return $config;
?>
