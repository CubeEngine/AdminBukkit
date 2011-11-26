<?php
    class RegisterForm extends CFormModel
    {
        public $username = 'a';
        public $email = 'a@b.c';
        public $password;
        public $password_repeat;

        public function rules()
        {
            return array(
                array('username, email, password, password_repeat', 'required'),
                array('username', 'length', 'min' => 5, 'max' => 40),
                array('email', 'email'),
                array('email', 'length', 'max' => 100),
                //array('password', 'compare'),
            );
        }

        public function createUser()
        {
            if ($this->password != $this->password_repeat)
            {
                $this->addError('password_repeat', Yii::t('register', 'The passwords do not match!'));
                return null;
            }
            try
            {
                return User::createUser($this->username, $this->password, $this->email);
            }
            catch (CModelException $e)
            {
                switch ($e->getCode())
                {
                    case User::ERR_NAME_USED:
                        $this->addError('username', Yii::t('register', 'The name is already in use!'));
                        break;
                    case User::ERR_EMAIL_USED:
                        $this->addError('email', Yii::t('register', 'The email address is already in use!'));
                        break;
                }
            }
            catch (Exception $e)
            {
                $this->addError('*', Yii::t('register', 'Failed to create the user due to a unknown error!'));
            }
            return null;
        }
    }
?>
