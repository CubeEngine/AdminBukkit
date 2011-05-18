<?php
    class SessIDFilter implements IFilter
    {
        private $sessionName;
        private $sessionID;
        
        public function __construct($name, $id)
        {
            $this->sessionName = $name;
            $this->sessionID = $id;
        }
        
        public function execute(&$string)
        {
            output_add_rewrite_var($this->sessionName, $this->sessionID);
        }
    }
?>
