<?php
    class Design extends Template
    {
        protected $title;
        protected static $minorTitles = array();
    
        public function __construct($title)
        {
            $this->title = $title;
            
            parent::__construct('index/index', Router::instance()->getLinkGenerator());
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
        
        public function setContentView(View $tpl)
        {
            $this->addSubtemplate('page', $tpl);
        }
    }
?>
