<?php
    import('Controller.Controller');
    import('Controller.ModuleException');
    import('View.View');
    import('View.Template');
    //import('Controller.Widget');

    abstract class Module
    {
        protected $modulePath;
        protected $request;
        protected $response;
        protected $name;

        final public function __construct(Request $request, Response $response)
        {
            $this->request = $request;
            $this->response = $response;
            $this->name = $request->getModule();
            $this->modulePath = Application::getPath('modules') . DS . $this->name;
        }
        
        abstract public function route(Request $request);

        public function getWidget($name)
        {
            // @todo load widget
        }

        public function getView($name)
        {
            $path = $this->modulePath . DS . 'Views' . DS . str_replace('.', DS, $name) . '.php';
            if (is_readable($path))
            {}
        }
        
        public function getModel($name)
        {
            $modelPath = $this->modulePath . DS . 'Models' . DS . $name . '.php';
            $modelClass = $name . 'Model';
            if (is_readable($modelPath))
            {
                $modelInstance = new $modelClass();
                if ($modelInstance instanceof Model)
                {
                    return $modelInstance;
                }
                else
                {
                    throw new ModuleException('Invalid model requested!');
                }
            }
            else
            {
                throw new ModuleException('Model does not exist or is not readable!');
            }
        }

        public function getController($name)
        {
            $controllerPath = $this->modulePath . DS . 'Controllers' . DS . $name . '.php';
            $controllerClass = $name . 'Controller';
            if (!class_exists($controllerClass))
            {
                if (is_readable($controllerPath))
                {
                    require_once $controllerPath;
                    if (!class_exists($controllerClass))
                    {
                        throw new ModuleException('Invalid controller requested!');
                    }
                }
                else
                {
                    throw new ModuleException("Controller not found or not readable!\n$controllerPath");
                }
            }
            $controllerInstance = new $controllerClass();
            if ($controllerInstance instanceof Controller)
            {
                return $controllerInstance;
            }
            else
            {
                throw new ModuleException('Controllers have to implement Controller!');
            }
        }
    }
?>
