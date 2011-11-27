<?php
    class UserController extends AccessControlledController
    {
        public $defaultAction = 'login';

        public function accessRules()
        {
            return array(
                array(
                    'allow',
                    'users' => array('@'),
                    'actions' => array('logout'),
                ),
                array(
                    'allow',
                    'users' => array('?'),
                    'actions' => array('login', 'register')
                ),
                array('deny')
            );
        }
        
        public function actionLogin()
        {
            $this->title = Yii::t('login', 'Login');
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('register', Yii::t('register', 'Registration'), Yii::app()->createUrl('user/register'));

            $loginForm = new LoginForm();
            if (isset($_REQUEST['LoginForm']))
            {
                $loginForm->setAttributes($_REQUEST['LoginForm']);
                if ($loginForm->validate() && $loginForm->login())
                {
                    Yii::app()->session['message'] = new Message(Yii::t('login', 'Logged in!'), Yii::t('login', 'You are now logged in!'));
                    $this->redirect(Yii::app()->user->returnUrl);
                }
                else
                {
                    Yii::app()->session['message'] = new Message(Yii::t('login', 'Failt to log in!'), $loginForm->getErrors());
                }
            }
            
            $this->render('login', array('model' => $loginForm));
            
        }

        public function actionLogout()
        {
            Yii::app()->session['message'] = new Message(Yii::t('logout', 'Logged out!'), Yii::t('logout', 'You are now logged out!'));
            Yii::app()->user->logout();
            $this->redirect(array('index/home'));
        }

        public function actionRegister()
        {
            $this->title = Yii::t('register', 'Registration');
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('login', Yii::t('login', 'Login'), Yii::app()->createUrl('user/login'));

            $registerForm = new RegisterForm();
            if (isset($_POST['RegisterForm']))
            {
                $registerForm->setAttributes($_POST['RegisterForm']);
                if ($registerForm->validate())
                {
                    $user = User::createUser($registerForm->username, $registerForm->password, $registerForm->email);
                    if ($user)
                    {
                        Yii::app()->user->login($user);
                        Yii::app()->session['message'] = new Message(Yii::t('register', 'Registration complete!'), Yii::t('register', 'You have been successfully registered and logged in!'));
                        $this->redirect(array('index/home'));
                    }
                }
                Yii::app()->session['message'] = new Message(Yii::t('register', 'Registration failed!'), $registerForm->getErrors());
            }

            $this->render('register', array('model' => $registerForm));
        }
    }
?>
