<?php
    require_once 'init.php';
    
    $user = User::currentlyLoggedIn();
    if (!$user)
    {
        header('HTTP/1.1 401 Unauthorized');
        die('2');
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
        $server = $user->getCurrentServer();
        if (!$server)
        {
            header('HTTP/1.1 400 Bad Request');
            die('No server selected!');
        }
        $api = new ApiBukkit($server);
        $api->setUseragent('AdminBukkit(' . $_SESSION['user']->getName() . ",{$_SERVER['REMOTE_ADDR']})");
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
        
        $contentType = $response->getHeader('Content-Type');
        if ($contentType)
        {
            header(strval($contentType));
        }

        echo $response->getBody();
    }
    catch (NetworkException $e)
    {
        onException($e, true);
        header('HTTP/1.1 503 Internal Server Error');
        die('0');
    }
    catch (Exception $e)
    {
        onException($e, true);
        header('HTTP/1.1 503 Internal Server Error');
        die('-1');
    }
?>
