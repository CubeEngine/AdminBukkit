<?php
    class ServerForm extends CFormModel
    {
        public $alias;
        public $host;
        public $port;
        public $authkey;

        public function __construct($scenario = '', $server = null)
        {
            parent::__construct($scenario);

            if ($server instanceof Server)
            {
                $this->alias = $server->getAlias();
                $this->host = $server->getHost();
                $this->port = $server->getPort();
                $this->authkey = $server->getAuthKey();
            }
        }

        public function rules()
        {
            return array(
                array('alias, host, port, authkey', 'required'),
                array('alias', 'length', 'max' => 30),
                array('host', 'length', 'max' => 100),
                array('host', 'host'),
                array('port', 'port')
            );
        }

        public function port($attrib, $params)
        {
            $port = intval($this->{$attrib});
            if ($port > 0 && $port < 65336)
            {
                return;
            }
            $this->addError($attrib, Yii::t('server', 'You have to specify a port between 0 and 65336!'));
        }

        public function host($attrib, $params)
        {
            $host = $this->{$attrib};
            $ip = gethostbyname($host);
            if (preg_match('/^\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}$/', $ip))
            {
                return;
            }
            $this->addError($attrib, Yii::t('server', 'The host is not valid!'));
        }

        public function validate($attributes = null, $clearErrors = true)
        {
            if (!parent::validate($attributes, $clearErrors))
            {
                return false;
            }

            $apiBukkit = new ApiBukkit($this->host, $this->port, $this->authkey);

            try
            {
                if ($apiBukkit->request('apibukkit')->getStatus() != 200)
                {
                    $this->addError('authkey', Yii::t('server', 'The given authkey is wrong!'));
                    return false;
                }
            }
            catch (NetworkException $e)
            {
                $this->addError('*', Yii::t('server', 'Could not connect to the API server!'));
                return false;
            }

            return true;
        }
    }
?>
