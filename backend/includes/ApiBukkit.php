<?php
    class ApiBukkit
    {
        protected $http;
        protected $pass;
        
        public function __construct($host, $port, $pass = '')
        {
            $http = new HttpClient();
            $http->setHost($host);
            $http->setPort($port);
            $http->addHeader(new HttpHeader('Connection', 'close'));
            $http->setMethod(new PostRequestMethod());
            $this->http = $http;
            $this->pass = $pass;
        }
        
        public function requestPath($path, array $params = array())
        {
            $path = '/' . ltrim(trim($path), '/');
            $params['authkey'] = $this->pass;
            $this->http->setTarget($path);
            $this->http->setRequestBody($this->http->generateQueryString($params));
            return $this->http->executeRequest();
        }
        
        public function request($controller, $action, array $params = array())
        {
            return $this->requestPath("/$controller/$action", $params);
        }
    }
?>
