<?php
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'init.php';

    import('Controller.FrontController');
    import('Request.Request');
    import('Request.Response');
    import('Application.Application');
    
    //echo '<pre>';
    //var_dump($_SERVER);
    //die();
    
    try
    {
        Application::initalize('AdminBukkit');
        
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
