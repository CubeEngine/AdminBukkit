<?php

    $yii    = dirname(__FILE__) . '/yii/yii.php';
    $config = dirname(__FILE__) . '/protected/config/apiproxy.php';

    defined('YII_DEBUG')        or define('YII_DEBUG',          true);
    defined('YII_TRACE_LEVEL')  or define('YII_TRACE_LEVEL',    3);

    require_once $yii;
    Yii::createWebApplication($config)->run();

?>
