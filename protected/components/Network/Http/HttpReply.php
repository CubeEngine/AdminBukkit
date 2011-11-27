<?php
    class HttpReply
    {
        protected $status;
        protected $message;
        protected $protocol;
        protected $body;
        protected $head;
        protected $headers;
        protected $cookies;
        
        public function __construct($protocol, $status, $message, $body, $head, array $headers, array $cookies)
        {
            $this->status = $status;
            $this->message = $message;
            $this->protocol = $protocol;
            $this->body = $body;
            $this->head = $head;
            $this->headers = $headers;
            $this->cookies = $cookies;
        }
        
        public function __toString()
        {
            return "{$this->protocol} {$this->status} {$this->message}";
        }
        
        /**
         * Returns the response body
         *
         * @return string the response body
         */
        public function getBody()
        {
            return $this->body;
        }
        
        /**
         * Returns the status code
         *
         * @return int the status code
         */
        public function getStatus()
        {
            return $this->status;
        }
        
        /**
         * Returns the status message
         *
         * @return string the status message
         */
        public function getMessage()
        {
            return $this->message;
        }
        
        /**
         * Returns the protocol with which the server responded
         *
         * @return string the protocal
         */
        public function getProtocol()
        {
            return $this->protocol;
        }
        
        /**
         * Returns the response header as a string
         *
         * @return string the raw response header
         */
        public function getHead()
        {
            return $this->head;
        }
        
        /**
         * Returns the named response header or null if not found
         *
         * @param string $name the name
         * @return HttpHeader the response header
         */
        public function getHeader($name)
        {
            $name = strtolower($name);
            if (isset($this->headers[$name]))
            {
                return $this->headers[$name];
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Return all response headers
         *
         * @return HttpHeader[] the response headers
         */
        public function getHeaders()
        {
            return $this->headers;
        }

        /**
         * Returns the named cookie or null if it does not exist
         *
         * @param string $name the name
         * @return HttpCookie the cookie
         */
        public function getCookie($name)
        {
            if (isset($this->cookies[$name]))
            {
                return $this->cookies[$name];
            }
            else
            {
                return null;
            }
        }

        /**
         * Returns all cookies
         *
         * @access public
         * @return HttpCookie[] all the cookies
         */
        public function getCookies()
        {
            return $this->cookies;
        }

        /**
         * Counts all set cookies
         *
         * @access public
         * @return int the count of the cookies
         */
        public function countCookies()
        {
            return count($this->cookies);
        }
    }
?>
