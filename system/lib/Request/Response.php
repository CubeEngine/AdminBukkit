<?php
    /**
     *
     */
    class Response
    {
        protected $headers;
        protected $content;

        public function __construct()
        {
            $this->headers = array();
        }
        
        public function headerExists($name)
        {
            return isset($this->headers[$name]);
        }
        
        public function addHeader($name, $value)
        {
            $this->addHeader(strval($name), strval($value));
        }
        
        public function getHeader($name)
        {
            if ($this->headerExists($name))
            {
                return $this->headers[$name];
            }
            else
            {
                return null;
            }
        }
        
        public function removeHeader($name)
        {
            unset($this->headers[$name]);
        }
        
        public function setContent($content)
        {
            $this->content = $content;
        }
        
        public function getContent()
        {
            return $this->content;
        }
        
        public function send()
        {
            echo $this->content;
        }
    }
?>
