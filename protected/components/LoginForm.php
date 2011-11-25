<?php
    class LoginForm extends CFormModel
    {
        public $id;
        public $password;
        public $nocookies = false;
        
        private $user;
        
        public function rules()
        {
            return array(
                array('id, password', 'required'),
                array('nocookies', 'boolean'),
                array('password', 'authenticate')
            );
        }
        
        public function attributeLabels()
        {
            return array(
                'id'        => Yii::t('login', 'Your Login ID'),
                'password'  => Yii::t('login', 'Your Password'),
                'id'        => Yii::t('login', 'Disable Cookies?')
            );
        }
        
        public function authenticate($password, $params)
        {
            $user = User::get($this->id);
            if ($user)
            {
                $user->setPassword($password);
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
    }
?>
