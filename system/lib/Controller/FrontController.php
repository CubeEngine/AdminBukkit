<?php
    import('Controller.ControllerException');
    import('Models.Request');
    import('Models.Response');

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
            $controller = $request->getController();
            $action = 'action_' . $request->getAction();

            $controllerPath = $this->controllerPath . DS . $controller . DS . 'controller.php';
            $controller = ucfirst(strtolower($controller)) . 'Controller';

            if (is_readable($controllerPath))
            {
                require_once $controllerPath;
                if (class_exists($controller))
                {
                    $controller = new $controller($request, $response);
                    if ($controller instanceof  AbstractController)
                    {
                        try
                        {
                            if (is_callable(array($controller, $action)))
                            {
                                $controller->$action();
                            }
                            else
                            {
                                $controller->action_index();
                            }
                            unset($controller);
                        }
                        catch (ControllerException $e)
                        {
                            echo $e->getMessage();
                        }
                        catch (Exception $e)
                        {
                            throw new Exception($e->getMessage(), $e->getCode());
                        }
                    }
                    else
                    {
                        throw new ControllerException("Invalid controller!\ncontrollers have to extend AbstractController");
                    }
                }
                else
                {
                    throw new ControllerException("Controller class not found!\n$controller");
                }
                
            }
            else
            {
                throw new ControllerException("The controller was not found or is not readable!\n$controllerPath");
            }
        }
    }
?>
