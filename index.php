<?php
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'init.php';

    import('Util.Registry');
    import('Util.Configuration.INIFileConfiguration');
    import('Debug.Debug');
    import('Models.Session');
    import('Controller.FrontController');
    import('Request.Request');
    import('Request.Response');

    Registry::set('paths.logs',         SYS_PATH . DS . 'logs'      );
    Registry::set('paths.locales',      SYS_PATH . DS . 'language'  );
    Registry::set('paths.controllers',  SYS_PATH . DS . 'pages'     );
    Registry::set('paths.configs',      SYS_PATH . DS . 'configs'   );
    Registry::set('paths.downloads',    SYS_PATH . DS . 'downloads' );
    Registry::set('paths.templates',    SYS_PATH . DS . 'templates' );
    Registry::set('debug.printErrors',  true                        );

    set_error_handler(array('Debug', 'error_handler'), -1);
    set_exception_handler(array('Debug', 'exception_handler'));
    register_shutdown_function(array('Debug', 'fatalerror_handler'));

    $config = new INIFileConfiguration(Registry::get('paths.configs') . DS . 'main.ini');
    $config->load();
    Registry::set('config', $config);


    Logger::setLogLevel(Registry::get('config')->get('logLevel', 0));
    date_default_timezone_set($config->get('timezone', 'Europe/Berlin'));
    Session::setName($config->get('sessionName', 'sid'));
    Session::setLifetime($config->get('sessionCookieLiftime', 3600));
    
    //echo '<pre>';
    //var_dump($_SERVER);
    //die();
    
    try
    {
        $frontcontroller = new FrontController();
        //$frontcontroller->setControllerPath(ICMS_SYS_PATH . 'pages/frontend/');
        $request = new Request();
        $response = new Response();

        $time = Debug::benchmark(array($frontcontroller, 'run'), array($request, $response), $result);

        $response->send();

        echo "\n\nRuntime: $time seconds\n\n\n\n";
    }
    catch (Exception $e)
    {
        Debug::printException($e);
        Debug::logException($e);
    }
?>
