<?php
    class Message extends CWidget
    {
        public function run()
        {
            $session = Yii::app()->session;
            if (isset($session['message']))
            {
                $this->render('message', array(
                    'title' => 'Message',
                    'message' => $session
                ));
            }
        }
    }
?>
