<?php
    class AccessControlledController extends Controller
    {
        public function filters()
        {
            return array(
                'accessControl'
            );
        }

        public function accessRules()
        {
            return array(
                'deny' => array(
                    'users' => '?',
                )
            );
        }
    }
?>
