<?php
    /**
     *
     */
    interface Crypter
    {
        public function __construct($key, $algo);
        public function encrypt($data);
        public function decrypt($data);
    }
?>
