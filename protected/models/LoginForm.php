<?php
    class LoginForm extends CFormModel
    {
        public $id;
        public $password;
        public $nocookies = false;
        
        private $user = null;
        
        public function rules()
        {
            return array(
                array('id, password', 'required'),
                array('nocookies', 'boolean'),
                array('password', 'authenticate')
            );
        }
        
        public function authenticate($attribute, $params)
        {
            $user = User::get($this->id);
            if ($user)
            {
                $user->setPassword($this->password);
                if ($user->authenticate())
                {
                    $this->user = $user;
                }
                else
                {
                    $this->addError('password', Yii::t('login', 'Wrong password given!'));
                }
            }
            else
            {
                $this->addError('id', Yii::t('login', 'ID not found!'));
            }
        }

        public function login()
        {
            if ($this->user)
            {
                $this->user->login();
                return true;
            }
            return false;
        }
    }
?>
