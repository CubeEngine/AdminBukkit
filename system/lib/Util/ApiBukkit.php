<?php
    import('Network.Http.HttpClient');

    class ApiBukkit
    {
        private $client;
        private $server;
        private $useragent;
        
        public function __construct(Server $server)
        {
            $client = new HttpClient();
            $client->setHost($server->getHost());
            $client->setPort($server->getPort());
            $client->addHeader(new HttpHeader('Connection', 'close'));
            $client->setMethod(new PostRequestMethod());
            $this->client = $client;
            $this->server = $server;

            $this->useragent = null;
        }

        /**
         * Requests a path on the API server with the given params and returns the HTTP response
         *
         * @param string $path the path to request on the API server
         * @param array $params the params to pass to the API server
         * @return HttpReply the response from the API server
         */
        public function requestPath($path, array $params = array())
        {
            $path = '/' . ltrim(trim($path), '/');
            $params['authkey'] = $this->server->getAuthKey();
            if ($this->useragent !== null)
            {
                $this->client->addHeader(new HttpHeader("apibukkit-useragent", $this->useragent));
            }
            $this->client->setTarget($path);
            $this->client->setRequestBody($this->client->generateQueryString($params));
            return $this->client->executeRequest();
        }
        
        public function request($controller, $action, array $params = array())
        {
            return $this->requestPath("/$controller/$action", $params);
        }

        public function getUseragent()
        {
            return $this->useragent;
        }

        public function setUseragent($useragent)
        {
            $this->useragent = strval($useragent);
            return $this;
        }

        public function getClient()
        {
            return $this->client;
        }

        public function getServer()
        {
            return $this->server;
        }
    }
?>
