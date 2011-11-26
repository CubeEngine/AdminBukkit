<?php
    class MessageBox extends CWidget
    {
        public function run()
        {
            $session = Yii::app()->session;
            if (isset($session['message']))
            {
                $message = $session['message'];
                if (is_object($message) && $message instanceof Message)
                {
                    unset($session['message']);
                    $messages = array();
                    $this->extractMessages($message->getMessage(), $messages);
                    $this->render('message', array(
                        'title' => $message->getTitle(),
                        'messages' => $messages
                    ));
                }
            }
        }

        private function extractMessages($array, &$list)
        {
            if (is_array($array) || $array instanceof Traversable)
            {
                foreach ($array as $message)
                {
                    $this->extractMessages($message, $list);
                }
            }
            else
            {
                $list[] = strval($array);
            }
        }
    }
?>
