<?php
    class ApiproxyController extends Controller
    {
        public $defaultAction = 'handle';

        public function actionHandle()
        {
            $user = User::get(Yii::app()->user->getId());;
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
                $server = $user->getSelectedServer();
                if (!$server)
                {
                    header('HTTP/1.1 400 Bad Request');
                    die('No server selected!');
                }
                $api = ApiBukkit::getFromServer($server);
                $api->setUseragent('AdminBukkit(' . $user->getName() . ",{$_SERVER['REMOTE_ADDR']})");
                $response = $api->requestPath($_SERVER['PATH_INFO'], array_merge($_POST, $_GET));
                $responseStatus = $response->getStatus();

                // Stats
                $parts = explode('/', trim($_SERVER['PATH_INFO'], '/'));
                if (count($parts) > 1)
                {
                    $stat = null;
                    if ($responseStatus == 200 || $responseStatus == 204)
                    {
                        $stat = new Statistic('api.succeeded.' . $parts[0] . '_' . $parts[1]);
                    }
                    else
                    {
                        $stat = new Statistic('api.failed.' . $parts[0] . '_' . $parts[1]);
                    }
                    $stat->increment();
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
                //onException($e, true);
                header('HTTP/1.1 503 Internal Server Error');
                die('0');
            }
            catch (Exception $e)
            {
                //onException($e, true);
                header('HTTP/1.1 503 Internal Server Error');
                var_dump($e);
                die('-1');
            }
        }
    }
?>
