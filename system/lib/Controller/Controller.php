<?php
    import('Controller.ControllerException');
    import('Request.Request');
    import('Request.Response');

    /**
     * Abstract base class which must be implemented by every controller
     */
    interface Controller
    {
        public function __construct();
        public function run(Request $request, Response $response);
    }
?>
