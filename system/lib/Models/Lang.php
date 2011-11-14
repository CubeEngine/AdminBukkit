<?php
    class Lang implements ArrayAccess
    {
        private static $instances = array();
        protected static $language = null;
        protected $logger;
        
        protected $lang;
        
        private function __construct($name)
        {
            $this->logger = Logger::instance('lang');
            $this->lang = array();
            $lang = self::getLanguage();
            $this->logger->write(3, 'info', 'Selected language "' . $lang . '"');
            $path = LANG_PATH . DS . $lang . DS . $name . '.lang.php';
            if (is_readable($path))
            {
                $this->lang = include $path;
                if (!is_array($this->lang))
                {
                    throw new Exception('The given language file is invalid!');
                }
                $this->logger->write(4, 'success', 'Language loaded');
            }
            else
            {
                $this->logger->write(1, 'fail', 'Language file not readable');
                throw new Exception('The given language file does not exist or is not readable! ' . $path);
            }
        }
        
        private function __clone()
        {}
        
        public static function instance($name)
        {
            if (!isset(self::$instances[$name]))
            {
                self::$instances[$name] = new self($name);
            }
            return self::$instances[$name];
        }
        
        public function get($name)
        {
            if (isset($this->lang[$name]))
            {
                $this->logger->write(4, 'info', 'Entry "' . $name . '" found!');
                $this->logger->write(5, 'info', 'Value: "' . $this->lang[$name] . '"');
                return $this->lang[$name];
            }
            else
            {
                $this->logger->write(3, 'fail', 'Entry "' . $name . '" NOT found!');
                return $name;
            }
        }
        
        public function getParsed($name, array $params = array())
        {
            $entry = $this->get($name);
            $placeholders = array();
            $values = array();
            foreach ($params as $index => $value)
            {
                $placeholders[] = '{' . $index . '}';
                $values[] = strval($value);
            }
            return str_replace($placeholders, $values, $entry);
        }
        
        public function out($name)
        {
            echo $this->get($name);
        }
        
        public function outParsed($name, array $params = array())
        {
            echo $this->getParsed($name, $params);
        }
        
        public function getMap()
        {
            return $this->lang;
        }
        
        public function __get($name)
        {
            $this->out($name);
        }
        
        public function __call($name, $arguments)
        {
            $this->outParsed($name, $arguments);
        }
        
        public static function getBestLanguage()
        {
            $languages = self::listLanguages();
            $acceptLang = self::parseAcceptLanguage();
            
            foreach ($acceptLang as $lang)
            {
                if (in_array($lang, $languages))
                {
                    return $lang;
                }
            }
            
            return Config::instance('bukkitweb')->get('defaultLanguage', 'en');
        }
        
        public static function listLanguages()
        {
            static $langs = array();
            if (!count($langs))
            {
                $dir = @opendir(LANG_PATH);
                if ($dir === false)
                {
                    throw new Exception('Counld not open the language directory!');
                }
                $langs = array();
                while (($entry = readdir($dir)))
                {
                    if (is_dir(LANG_PATH . DS . $entry))
                    {
                        if (!preg_match('/^\.\.?$/', $entry))
                        {
                            $langs[] = $entry;
                        }
                    }
                }
                @closedir($dir);
            }
            return $langs;
        }
        
        protected static function parseAcceptLanguage()
        {
            $langs = array(Config::instance('bukkitweb')->get('defaultLanguage', 'en'));

            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
            {
                preg_match_all('/(([a-z]{1,8})(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

                if (count($lang_parse[1]))
                {
                    $langs = array_combine($lang_parse[2], $lang_parse[5]);
                    foreach ($langs as $lang => $val)
                    {
                        if ($val === '') 
                        {
                            $langs[$lang] = 1;
                        }
                    }
                    arsort($langs, SORT_NUMERIC);
                    return array_keys($langs);
                }
            }
            
            return $langs;
        }
        
        public static function getLanguage()
        {
            if (self::$language === null)
            {
                $lang = null;

                $post = Request::post('lang');
                $get = Request::get('lang');
                $session = ((isset($_SESSION['lang']) && $_SESSION['lang'] !== '') ? $_SESSION['lang'] : '');
                if (!empty($post))
                {
                    $lang =& $post;
                }
                elseif (!empty($get))
                {
                    $lang =& $get;
                }
                elseif (!empty($session))
                {
                    $lang =& $session;
                }
                
                if (!in_array($lang, self::listLanguages()))
                {
                    $lang = self::getBestLanguage();
                }

                $_SESSION['lang'] = $lang;
                self::$language = $lang;
                return $lang;
            }
            else
            {
                return self::$language;
            }
        }

        public function offsetExists($offset)
        {
            return isset($this->lang[$offset]);
        }

        public function offsetGet($offset)
        {
            return $this->get($offset);
        }

        public function offsetSet($offset, $value)
        {} // not supported

        public function offsetUnset($offset)
        {} // not supported
    }
?>
