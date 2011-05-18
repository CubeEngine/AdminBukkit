<?php
    class Design extends Template
    {
        protected $title;
        protected static $minorTitles = array();
    
        public function __construct($title)
        {
            $this->title = $title;
            parent::__construct('index/index');
            $this->assign('theme', Config::instance('bukkitweb')->get('theme'));
        }
        
        public static function addMinorTitle($title)
        {
            self::$minorTitles[] = $title;
        }
        
        public static function clearMinorTitles()
        {
            self::$minorTitles = array();
        }
        
        public function render()
        {
            $this->assign('title', $this->title);
            $this->assign('minorTitles', self::$minorTitles);
            return parent::render();
        }
        
        public function setContentTpl(Template $tpl)
        {
            $this->addSubtemplate('page', $tpl);
        }
    }
?>
