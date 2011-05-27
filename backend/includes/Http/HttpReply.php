<?php
    class HttpReply
    {
        protected $status;
        protected $message;
        protected $protocol;
        protected $body;
        protected $responseHead;
        protected $responseHeaders;
        protected $cookies;
        
        public function __construct($protocol, $status, $message, $body, $responseHead, array $responseHeaders, array $cookies)
        {
            $this->status = $status;
            $this->message = $message;
            $this->protocol = $protocol;
            $this->body = $body;
            $this->responseHead = $responseHead;
            $this->responseHeaders = $responseHeaders;
            $this->cookies = $cookies;
        }
        
        public function __toString()
        {
            return "{$this->protocol} {$this->status} {$this->message}";
        }
        
        /**
         * Returns the response body
         *
         * @access public
         * @return string the response body
         */
        public function getBody()
        {
            return $this->body;
        }
        
        /**
         * Returns the status code
         *
         * @access public
         * @return int the status code
         */
        public function getStatus()
        {
            return $this->status;
        }
        
        /**
         * Returns the status message
         *
         * @access public
         * @return string the status message
         */
        public function getMessage()
        {
            return $this->message;
        }
        
        /**
         * Returns the protocol with which the server responded
         *
         * @access public
         * @return string the protocal
         */
        public function getProtocol()
        {
            return $this->protocol;
        }
        
        /**
         * Returns the response header as a string
         *
         * @access public
         * @return string the raw response header
         */
        public function getResponseHead()
        {
            return $this->responseHead;
        }
        
        /**
         * Returns the named response header or null if not found
         *
         * @access public
         * @param string $name the name
         * @return HttpHeader the response header
         */
        public function getResponseHeader($name)
        {
            if (isset($this->responseHeaders[$name]))
            {
                return $this->responseHeaders[$name];
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Return all response headers
         *
         * @access public
         * @return HttpHeader[] the response headers
         */
        public function getResponseHeaders()
        {
            return $this->responseHeaders;
        }        /**
         * Returns the named cookie or null if it does not exist
         *
         * @access public
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
