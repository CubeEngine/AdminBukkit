<?php
    class JavascriptController extends Controller
    {
        public function actionIndex()
        {}

        public function actionTranslation($cat)
        {
            $cacheLifetime = Yii::app()->params['cacheLifetime'];
            header('Content-Type: text/javascript;charset=utf-8');
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheLifetime) . ' GMT');
            header('Pragma: cache');
            header('Cache-Control: max-age=' . $cacheLifetime);

            $messageProvider = Yii::app()->getMessages();
            $method = new ReflectionMethod(get_class($messageProvider), 'loadMessages');
            $method->setAccessible(true);
            $messages = $method->invokeArgs($messageProvider, array($cat, Yii::app()->getLanguage()));

            $this->renderPartial('translation', array(
                'cat'           => $cat,
                'messages'      => $messages,
                'messageCount'  => count($messages)
            ));
        }
    }
?>
