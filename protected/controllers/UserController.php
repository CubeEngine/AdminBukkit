<?php
    class UserController extends Controller
    {
        public $defaultAction = 'login';
        
        public function actionLogin()
        {
            $user = User::get('root');
            if ($user->authenticate('sicher'))
            {
                $app = Yii::app();
                $app->user->login($user);
            }
            
        }

        public function actionLogout()
        {

        }

        public function actionRegister()
        {
            
        }
    }
?>
