<?php
    import('Controller.BasicPage');

    class IndexController extends BasicPage
    {
        public function __construct()
        {
            parent::__construct('Index', false);
        }
        
        public function run(Request $request, Response $response)
        {
            echo 'Controller: index<br />';
            throw new Reroute('downloads', new Route('test', array()));
        }
    }
?>
