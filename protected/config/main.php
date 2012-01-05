<?php
    return array(
        'basePath' => dirname(dirname(__FILE__)),
        'name' => 'AdminBukkit',
        'defaultController' => 'index',

        'preload' => array('log'),

        'import' => array(
            'application.models.*',
            'application.components.*',
        ),

        'modules' => array(
            // uncomment the following to enable the Gii tool

            'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => 'sicher',
                 // If removed, Gii defaults to localhost only. Edit carefully to taste.
                'ipFilters' => array('127.0.0.1','::1'),
            ),

        ),
        
        'behaviors' => array(
        ),

        'components' => array(
            'user' => array(
                'allowAutoLogin' => true,
                'autoRenewCookie' => true,
                'loginUrl' => array('user/login'),
            ),
            'urlManager' => array(
                'urlFormat' => 'path',
                'showScriptName' => false,
                'rules' => array(
                    '<language:[a-z][a-z]>/<controller:\w+>s' => '<controller>/list',
                    '<language:[a-z][a-z]>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<language:[a-z][a-z]>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    '<controller:\w+>s' => '<controller>/list',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                ),
            ),
            'db' => array(
                'connectionString' => 'sqlite:' . dirname(dirname(__FILE__)) . '/data/testdrive.db',
                'tablePrefix' => '',
            ),
            'db' => array(
                'connectionString'  => 'mysql:host=localhost;port=3306;dbname=adminbukkit_yii',
                'emulatePrepare'    => true,
                'username'          => 'root',
                'password'          => '',
                'charset'           => 'utf8',
                'tablePrefix'       => '',
            ),
            'errorHandler' => array(
                'errorAction' => 'index/error',
                //'discardOutput' => false
            ),
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class'=>'CFileLogRoute',
                        //'levels'=>'error, warning',
                    ),
                    // uncomment the following to show log messages on web pages
                    /*
                    array(
                        'class'=>'CWebLogRoute',
                    ),
                    */
                ),
            ),
        ),

        'params' => require dirname(__FILE__) . '/params.php',
    );
?>
