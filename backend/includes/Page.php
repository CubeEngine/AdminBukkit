<?php
    class Page extends Template
    {
        protected $content;
        protected $info;
        public function __construct($name, $title, $auth = false)
        {
            if ($auth && !User::loggedIn())
            {
                Router::instance()->redirectToLoginPage(Lang::instance('generic')->get('loginrequired'));
            }
            parent::__construct('generic/page');
            $this->assign('pageName', $name);
            $this->assign('pageTitle', $title);
            $this->addSubTemplate('copyright', new Template('generic/copyright'));
            $this->content = null;
            $this->info = $this->getSubtemplate('copyright');
            if (isset($_SESSION['message']))
            {
                $this->assign('message', $_SESSION['message']);
                unset($_SESSION['message']);
            }
        }
        
        public function setContent(View $content)
        {
            $this->content = $content;
            return $this;
        }
        
        public function setInfo($info)
        {
            $this->info = strval($info);
            return $this;
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
        
        public function setButton($text, $target)
        {
            $this->assign('btnText', $text);
            $this->assign('btnTarget', $target);
            return $this;
        }

        public function setBack($text, $target = null)
        {
            $this->assign('backText', $text);
            if ($target != null)
            {
                $this->assign('backTarget', $target);
            }
            return $this;
        }
    }
?>
