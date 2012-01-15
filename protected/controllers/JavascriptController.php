<?php
    class JavascriptController extends Controller
    {
        public function init()
        {
            parent::init();
            $cacheLifetime = Yii::app()->params['cacheLifetime'];
            header('Content-Type: text/javascript;charset=utf-8');
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheLifetime) . ' GMT');
            header('Pragma: cache');
            header('Cache-Control: max-age=' . $cacheLifetime);
        }

        public function actions()
        {
            return array(
                'api' => 'application.controllers.javascript.ApiAction',
            );
        }
        
        public function actionIndex()
        {}

        public function actionTranslation($cat)
        {
            $messages = array();
            $messageCount = 0;
            if (Yii::app()->language != Yii::app()->sourceLanguage)
            {
                $messageProvider = Yii::app()->getMessages();
                $loadMessages = new ReflectionMethod(get_class($messageProvider), 'loadMessages');
                $loadMessages->setAccessible(true);
                $messages = $loadMessages->invokeArgs($messageProvider, array($cat, Yii::app()->getLanguage()));
                $messageCount = count($messages);
                if (!$messageCount)
                {
                    $messages = null;
                }
            }

            $this->renderPartial('translation', array(
                'cat'           => $cat,
                'messages'      => $messages,
                'messageCount'  => $messageCount
            ));
        }
        
        public function actionItems()
        {
            $this->renderPartial('items');
        }

        public function actionJson()
        {
            header(JSONUtils::CONTENT_TYPE);

            $server = $this->app->request->getParam('server', null);
            $fullUsers = $this->app->request->getParam('users', null) !== null;
            if ($server !== null)
            {
                $server = trim($server);
                if (is_numeric($server))
                {
                    $server = $this->user->getServer($server);
                }
                elseif ($server == 'current')
                {
                    $server = $this->user->getCurrentServer();
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
