<?php
    require_once 'backend/init.php';

    Logger::logLevel(Config::instance('bukkitweb')->get('logLevel', 0));
    $design = new Design('Bukkit Web Admin');
    //$design->addPostFilter(new WhitespaceFilter());
    //$design->addPostFilter(new TidyFilter());
    //$design->addPostFilter(new SessIDFilter(session_name(), session_id()));
    
    $router = new Router();
    require_once $router->getPagePath();
    $design->display();
?>