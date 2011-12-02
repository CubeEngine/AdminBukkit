<?php
    class PluginController extends AccessControlledController
    {
        public $defaultAction = 'list';

        public function actionList()
        {
            $this->render('list', array('server' => $this->user->getCurrentServer()));
        }

        public function actionView()
        {
            $this->render('view', array('server' => $this->user->getCurrentServer()));
        }
    }
?>
