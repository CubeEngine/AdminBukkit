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
        
        public function actionIndex()
        {}

        public function actionTranslation($cat)
        {
            $messageProvider = Yii::app()->getMessages();
            $loadMessages = new ReflectionMethod(get_class($messageProvider), 'loadMessages');
            $loadMessages->setAccessible(true);
            $messages = $loadMessages->invokeArgs($messageProvider, array($cat, Yii::app()->getLanguage()));

            $this->renderPartial('translation', array(
                'cat'           => $cat,
                'messages'      => $messages,
                'messageCount'  => count($messages)
            ));
        }
        
        public function actionItems()
        {
            $this->renderPartial('items');
        }
    }
?>
