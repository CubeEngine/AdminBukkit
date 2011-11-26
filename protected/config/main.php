<?php
    return array(
        'basePath' => dirname(dirname(__FILE__)),
        'name' => 'AdminBukkit',
        'defaultController' => 'index',

        // preloading 'log' component
        'preload' => array('log'),

        // autoloading model and component classes
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

        // application components
        'components' => array(
            'user' => array(
                // enable cookie-based authentication
                'allowAutoLogin' => true,
                'autoRenewCookie' => true,
                'loginUrl' => array('user/login'),
            ),
            'urlManager' => array(
                'urlFormat' => 'path',
                'rules' => array(
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    '<controller:\w+>s' => '<controller>/list',
                ),
            ),
            'db' => array(
                'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
            ),
            'db' => array(
                'connectionString'  => 'mysql:host=localhost;dbname=adminbukkit_yii',
                'emulatePrepare'    => true,
                'username'          => 'root',
                'password'          => '',
                'charset'           => 'utf8',
                'tablePrefix'       => '',
            ),
            'errorHandler' => array(
                'errorAction' => 'index/error',
                'discardOutput' => false
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
