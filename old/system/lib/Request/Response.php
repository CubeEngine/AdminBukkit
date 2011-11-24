<?php
    import('View.MainView');
    import('View.Filter');

    /**
     *
     */
    class Response
    {
        protected $headers;
        protected $view;
        protected $content;
        protected $filters;

        public function __construct()
        {
            $this->headers = array();
            $this->filters = array();
        }
        
        public function headerExists($name)
        {
            return isset($this->headers[$name]);
        }
        
        public function addHeader($name, $value)
        {
            $this->headers[trim($name)] = strval($value);
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

        public function setView(MainView $view)
        {
            $this->view = $view;
        }
        
        public function setContent(View $content)
        {
            $this->content = $content;
        }
        
        public function getContent()
        {
            return $this->content;
        }

        public function addResponseFilter(Filter $filter)
        {
            $this->filters[] = $filter;
        }
        
        public function send()
        {
            foreach ($this->headers as $name => &$value)
            {
                header($name . ': ' . $value);
            }
            $response = '';
            if ($this->view)
            {
                $this->view->setContent($this->content);
                $response = $this->view->render();
            }
            elseif ($this->content)
            {
                $response = $this->content->render();
            }

            foreach ($this->filters as $filter)
            {
                $filter->execute($response);
            }

            echo $response;
        }
    }
?>
