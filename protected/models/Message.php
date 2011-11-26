<?php
    class Message
    {
        private $title;
        private $message;

        public function __construct($title, $message)
        {
            $this->title = $title;
            $this->message = $message;
        }

        public function getTitle()
        {
            return $this->title;
        }

        public function getMessage()
        {
            return $this->message;
        }
    }
?>
