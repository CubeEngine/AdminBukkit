<?php
    import('Controller.ControllerException');
    import('Request.Request');
    import('Request.Response');

    /**
     * The Frontcontroller which runs the requested page
     */
    final class FrontController
    {
        private $controllerPath;


        public function __construct()
        {
            $this->controllerPath = Registry::get('paths.controllers', '.' . DS . 'controllers');
        }

        public function run(Request $request, Response $response)
        {
            $router = $request->getModule();

            $routerPath = $this->controllerPath . DS . $router . DS . $router . 'Router.php';
            $router = ucfirst(strtolower($router)) . 'Router';

            if (is_readable($routerPath))
            {
                require_once $routerPath;
                if (class_exists($router))
                {
                    $router = new $router($request, $response);
                    if ($router instanceof Router)
                    {
                        try
                        {
                            $route = $router->route($request);
                            $action = $route->getAction();
                            if (is_callable(array($router, $action)))
                            {
                                $router->$action();
                            }
                            else
                            {
                                $router->action_index();
                            }
                            unset($router);
                        }
                        catch (ControllerException $e)
                        {
                            // @todo error pages
                            echo $e->getMessage();
                        }
                        catch (Exception $e)
                        {
                            throw new Exception($e->getMessage(), $e->getCode());
                        }
                    }
                    else
                    {
                        throw new ControllerException("Invalid router!\nRouters have to implement Router");
                    }
                }
                else
                {
                    throw new ControllerException("Router class '$router' not found!\n");
                }
                
            }
            else
            {
                throw new ControllerException("The router was not found or is not readable!\n$routerPath");
            }
        }
    }
?>
