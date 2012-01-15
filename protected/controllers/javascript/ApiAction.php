<?php
    class ApiAction extends CAction
    {
        private $app;

        public function __construct($controller, $id)
        {
            parent::__construct($controller, $id);
            $this->app = Yii::app();
        }

        public function run($action)
        {
            $methodName = 'action' . ucfirst(strtolower($action));
            if (@is_callable(array($this, $methodName)))
            {
                $this->{$methodName}();
            }
        }

        public function actionUser()
        {
            
        }
        
        public function actionServer()
        {
            header(JSONUtils::CONTENT_TYPE);

            $server = $this->app->request->getParam('server', null);
            $fullUsers = $this->app->request->getParam('users', null) !== null;
            if ($server !== null)
            {
                $server = trim($server);
                if (is_numeric($server))
                {
                    $server = User::getCurrent()->getServer($server);
                }
                elseif ($server == 'current')
                {
                    $server = User::getCurrent()->getCurrentServer();
                }
                if ($server !== null)
                {
                    echo JSONUtils::encode(JSONUtils::serializeServer($server, $fullUsers));
                }
            }
            else
            {
                echo 'null';
            }
        }
    }
?>
