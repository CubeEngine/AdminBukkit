<?php
    class UserController extends Controller
    {
        public $defaultAction = 'login';
        
        public function actionLogin()
        {
            $formModel = new LoginForm();
            if (isset($_POST['LoginForm']))
            {
                $formModel->setAttributes($_POST['LoginForm']);
                if ($formModel->validate())
                {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            
            $this->render('login', array('formModel', $formModel));
            
            
            $user = User::get('root');
            $user->setPassword('sicher');
            if ($user->authenticate())
            {
                $app = Yii::app();
                $app->user->login($user);
            }
            
        }

        public function actionLogout()
        {
            Yii::app()->user->logout();
        }

        public function actionRegister()
        {
            User::createUser($name, $password, $email);
        }
    }
?>
