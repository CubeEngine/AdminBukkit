<?php
    import('Controller.ControllerException');
    import('Request.Request');
    import('Request.Response');

    /**
     * Abstract base class which must be extended by every controller
     */
    abstract class Controller
    {
        protected $module;
        
        public function __construct(Module $module)
        {
            $this->module = $module;
        }
        
        abstract public function run(Request $request, Response $response);
        
        public function preExecution()
        {}
        
        public function postExecution()
        {}
    }
?>
