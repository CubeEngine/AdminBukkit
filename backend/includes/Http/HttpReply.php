<?php
    class HttpReply
    {
        protected $status;
        protected $message;
        protected $protocol;
        protected $body;
        protected $responseHead;
        protected $responseHeaders;
        
        public function __construct($status, $message, $protocol, $body, $responseHead, array $responseHeaders, array $cookies)
        {
            $this->status = $status;
            $this->message = $message;
            $this->protocol = $protocol;
            $this->body = $body;
            $this->responseHead = $responseHead;
            $this->responseHeaders = $responseHeaders;
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
        }
    }
?>
