<?php
    class Controller extends CController
    {
        private $app;
        private $user;
        private $langPath;
        private $languageAlreadySet = false;
        
        public $layout='//layouts/page';

        public $id;
        public $title;
        public $backButton;
        public $utilButton;

        public function init()
        {
            parent::init();

            if (!$this->languageAlreadySet)
            {
                $this->langPath = Yii::getPathOfAlias('application.messages') . '/';
                $this->setUserLanguage();
                $this->languageAlreadySet = true;
            }
        }

        private function isLanguageAvailable($lang)
        {
            return is_readable($this->langPath . $lang);
        }

        private function setUserLanguage()
        {
            $app = Yii::app();
            $user = $app->user;

            if (isset($_POST['language']))
            {
                if ($this->isLanguageAvailable($_GET['language']))
                {
                    $app->setLanguage($_GET['language']);
                    $user->setState('language', $_GET['language']);
                    return;
                }
            }
            if (isset($_POST['language']))
            {
                if ($this->isLanguageAvailable($_POST['language']))
                {
                    $app->setLanguage($_POST['language']);
                    $user->setState('language', $_POST['language']);
                    //$cookie = new CHttpCookie('language', $_POST['language']);
                    //$cookie->expire = time() + (60 * 60 * 24 * 365);
                    //Yii::app()->request->cookies['language'] = $cookie;
                    return;
                }
            }
            if ($user->hasState('language'))
            {
                $langState = $user->getState('language');
                if ($this->isLanguageAvailable($langState))
                {
                    $app->setLanguage($langState);
                    return;
                }
            }
            if (isset($app->request->cookies['language']))
            {
                $langCookie = $app->request->cookies['language']->value;
                if ($this->isLanguageAvailable($langCookie))
                {
                    $app->setLanguage($langCookie);
                    return;
                }
            }
            
            $matches = array();
            if( isset($_SERVER['HTTP_ACCEPTlanguageUAGE']) && ($n = preg_match_all('/([\w\-_]+)\s*(;\s*q\s*=\s*(\d*\.\d*))?/', $_SERVER['HTTP_ACCEPTlanguageUAGE'], $matches)) > 0)
            {
                $languages = array();
                for ($i = 0; $i < $n; ++$i)
                {
                    $languages[$matches[1][$i]] = empty($matches[3][$i]) ? 1.0 : floatval($matches[3][$i]);
                }
                arsort($languages);
                foreach($languages as $language => $pref)
                {
                    $language = CLocale::getCanonicalID($language);
                    if ($this->isLanguageAvailable($language))
                    {
                        $app->setLanguage($language);
                        $user->setState('language', $language);
                        break;
                    }
                }
            }
        }
    }
?>
