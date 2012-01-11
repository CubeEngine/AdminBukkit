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
                    $stat = new Statistic('user.login');
                    $stat->increment();
                    
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

            $stat = new Statistic('user.logout');
            $stat->increment();

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
                    try
                    {
                        $user = User::createUser($registerForm->username, $registerForm->password, $registerForm->email);
                        if ($user)
                        {
                            Yii::app()->user->login($user);
                            Yii::app()->session['message'] = new Message(Yii::t('register', 'Registration complete!'), Yii::t('register', 'You have been successfully registered and logged in!'));
                            $this->redirect(array('index/home'));
                        }
                    }
                    catch (CModelException $e)
                    {
                        switch ($e->getCode())
                        {
                            case User::ERR_NAME_USED:
                                $registerForm->addError('username', Yii::t('register', 'The given username is already in use!'));
                                break;
                            case User::ERR_EMAIL_USED:
                                $registerForm->addError('email', Yii::t('register', 'The given email address is already in use!'));
                                break;
                        }
                    }
                }
                Yii::app()->session['message'] = new Message(Yii::t('register', 'Registration failed!'), $registerForm->getErrors());
            }

            $this->render('register', array('model' => $registerForm));
        }

        public function actionDelete()
        {
            if (isset($_POST['ProfileDelete']['confirm']))
            {
                $this->user
                        ->logout()
                        ->delete();
                $this->render('delete_success');
            }
            else
            {
                $this->render('delete', array('user' => $this->user));
            }
        }
    }
?>
