<?php
    import('Request.Reroute');

    /**
     * The Frontcontroller which runs the requested page
     */
    final class FrontController
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

                $modulePath =  $modulePath . DS . $module . 'Module.php';
                $moduleClass = ucfirst(strtolower($module)) . 'Module';

                if (is_readable($modulePath))
                {
                    require_once $modulePath;
                    if (class_exists($moduleClass))
                    {
                        $moduleInstance = new $moduleClass($request, $response);
                        if ($moduleInstance instanceof Module)
                        {
                            try
                            {
                                if (!$route)
                                {
                                    $route = $moduleInstance->route($request);
                                }

                                $controller = null;
                                try
                                {
                                    $controller = $moduleInstance->getController($route->getController());
                                }
                                catch (ModuleException $e)
                                {
                                    $controller = $moduleInstance->getController('Index');
                                }

                                $controller->preExecution();
                                $controller->run($request, $response);
                                $controller->postExecution();
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
                            catch (ModuleException $e)
                            {
                                // @todo add real handling
                                throw $e;
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
                        throw new ControllerException("Module class '$module' not found!\n");
                    }

                }
                else
                {
                    throw new ControllerException("The router was not found or is not readable!\n$modulePath");
                }
            }
            catch (Reroute $e)
            {
                $this->run($request, $response, $e->getModule(), $e->getRoute());
            }
        }
    }
?>
