<?php
    require_once 'backend/init.php';

    Logger::logLevel(Config::instance('bukkitweb')->get('logLevel', 0));
    $router = Router::instance();
    $design = new Design('AdminBukkit');
    $design->assign('basePath', $router->getBasePath());
    //$design->addPostFilter(new WhitespaceFilter());
    //$design->addPostFilter(new TidyFilter());
    //$design->addPostFilter(new SessIDFilter(session_name(), session_id()));
    
    require_once $router->getPagePath();
    $design->display();
?>