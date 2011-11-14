<?php
    class SimpleException extends Exception
    {
        public function __construct($code)
        {
            parent::__construct('', $code);
        }
    }
?>
