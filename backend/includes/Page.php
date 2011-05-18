<?php
    class Page extends Template
    {
        protected $content;
        protected $info;
        public function __construct($name, $auth = false)
        {
            if ($auth && !User::loggedIn())
            {
                Router::redirectToLoginPage();
            }
            parent::__construct('generic/page');
            $this->assign('pageName', $name);
            $this->addSubTemplate('copyright', new Template('generic/copyright'));
            $this->content = null;
            $this->info = null;
        }
        
        public function setContent(IView $content)
        {
            $this->content = $content;
        }
        
        public function setInfo($info)
        {
            $this->info = strval($info);
        }
        
        public function render()
        {
            if ($this->content instanceof Template)
            {
                $this->addSubtemplate('content', $this->content);
            }
            if ($this->info !== null)
            {
                $this->assign('infoText', $this->info);
            }
            return parent::render();
        }
    }
?>
