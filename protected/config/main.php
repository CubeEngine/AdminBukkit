<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
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
            'allowAutoLogin'=>true,
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
        ),
        'errorHandler' => array(
            'errorAction' => 'index/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
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

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'administration@mc-portal.de',
        'downloadPath'=> dirname(dirname(__FILE__)) . '/downloads',
        'secret' => 'aw34tryw4ty4wt34wtyx34tsy3$TY§$TY§$TY§4ty4',
    ),
);