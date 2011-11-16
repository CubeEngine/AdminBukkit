<?php
    import('Controller.BasicPage');

    class TestController extends BasicPage
    {
        public function run(Request $request, Response $response)
        {
            echo 'Controller: test<br />';
        }
    }
?>
