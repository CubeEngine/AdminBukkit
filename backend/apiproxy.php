<?php
    require_once 'init.php';
    
    
    if (!User::loggedIn())
    {
        header('HTTP/1.1 403 Forbidden');
        die('Seems like the you\'re not logged in!');
    }
    
    $path = '';
    if (isset($_SERVER['PATH_INFO']) && trim($_SERVER['PATH_INFO']) !== '')
    {
        $path =& $_SERVER['PATH_INFO'];
    }
    else
    {
        header('HTTP/1.1 400 Bad Request');
        die('No path given!');
    }
    
    try
    {
        $api = new ApiBukkit($_SESSION['user']->getServerAddress(), $_SESSION['user']->getApiPort(), $_SESSION['user']->getApiPassword());
        $response = $api->requestPath($_SERVER['PATH_INFO'], array_merge($_POST, $_GET));
        $responseStatus = $response->getStatus();
        
        // Stats
        $parts = explode('/', trim($_SERVER['PATH_INFO'], '/'));
        if ($responseStatus == 200 || $responseStatus == 204)
        {
            Statistics::increment('api.succeeded.' . $parts[0] . '_' . $parts[1]);
        }
        else
        {
            Statistics::increment('api.failed.' . $parts[0] . '_' . $parts[1]);
        }
        header(strval($response));
        echo $response->getBody();
    }
    catch (PDOException $e)
    {
        header('HTTP/1.1 503 Internal Server Error');
        die('-1');
    }
    catch (Exception $e)
    {
        header('HTTP/1.1 503 Internal Server Error');
        die('0');
    }
?>
