<?php
    import('Controller.Controller');
    import('Request.Reroute');

    /**
     * The Frontcontroller which runs the requested page
     */
    final class FrontController implements Controller
    {
        private $modulePath;
        private $reroutes;
        private $rerouteLimit;


        public function __construct()
        {
            $this->reroutes = 1;
            $this->rerouteLimit = Application::getConfig()->get('rerouteLimit', 5);
            $this->modulePath = Application::getPath('modules');
        }

        public function run(Request $request, Response $response, $module = null, Route $route = null)
        {
            if (!$module)
            {
                $module = $request->getModule();
            }

            try
            {
                $modulePath = $this->modulePath . DS . $module;

                $routerPath =  $modulePath . DS . $module . 'Router.php';
                $routerClass = ucfirst(strtolower($module)) . 'Router';

                if (is_readable($routerPath))
                {
                    require_once $routerPath;
                    if (class_exists($routerClass))
                    {
                        $router = new $routerClass($request, $response);
                        if ($router instanceof Router)
                        {
                            try
                            {
                                if (!$route)
                                {
                                    $route = $router->route($request);
                                }
                                $controllerClass = ucfirst(strtolower($route->getController())) . 'Controller';

                                $controllerPath = $modulePath . DS . 'Controllers' . DS . $controllerClass . '.php';

                                if (is_readable($controllerPath))
                                {
                                    if (!class_exists($controllerClass))
                                    {
                                        require $controllerPath;
                                    }
                                    
                                    if (class_exists($controllerClass))
                                    {
                                        $controllerInstance = new $controllerClass();
                                        if ($controllerInstance instanceof Controller)
                                        {
                                            $controllerInstance->run($request, $response);
                                        }
                                        else
                                        {
                                            throw new ControllerException('Controllers have to implement Controller!');
                                        }
                                        unset($controllerInstance);
                                    }
                                    else
                                    {
                                        throw new ControllerException('Invalid controller!');
                                    }
                                }
                                else
                                {
                                    throw new ConfigurationException("Controller not found or not readable!\n$controllerPath");
                                }
                            }
                            catch (Reroute $e)
                            {
                                if ($this->reroutes < $this->rerouteLimit)
                                {
                                    ++$this->reroutes;
                                    throw $e;
                                }
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
                        throw new ControllerException("Router class '$module' not found!\n");
                    }

                }
                else
                {
                    throw new ControllerException("The router was not found or is not readable!\n$routerPath");
                }
            }
            catch (Reroute $e)
            {
                $this->run($request, $response, $e->getModule(), $e->getRoute());
            }
        }
    }
?>
