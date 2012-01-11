<?php
    class ProfileController extends AccessControlledController
    {
        public $defaultAction = 'view';

        public function actionView()
        {
            $this->title = Yii::t('profile', 'Profile');
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('profile_edit', Yii::t('generic', 'Edit'), $this->createUrl('profile/edit'));
            
            $this->render('view', array('user' => $this->user));
        }

        public function actionEdit()
        {
            $this->render('edit', array('user' => $this->user));
        }
    }
?>
