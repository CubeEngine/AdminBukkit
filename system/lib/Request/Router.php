<?php
    import('Request.Request');

    interface Router
    {
        public function route(Request $request);
    }
?>
