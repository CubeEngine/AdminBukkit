<?php
    class Toolbar extends Template
    {
        public function __construct($pageTitle)
        {
            parent::__construct('generic/toolbar');
            $this->assign('pageTitle', $pageTitle);
        }
        public function setButton($text, $target)
        {
            $this->assign('btnText', $text);
            $this->assign('btnTarget', $target);
        }
        
        public function setBack($text, $target = null)
        {
            $this->assign('backText', $text);
            if ($target != null)
            {
                $this->assign('backTarget', $target);
            }
        }
    }
?>
