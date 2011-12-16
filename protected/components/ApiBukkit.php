<?php
    Yii::import('application.components.Network.Http.HttpClient');

    class ApiBukkit
    {
        private $authkey;

        private $client;
        private $useragent;
        
        public function __construct($host, $port, $authkey, $useragent = null)
        {
            $client = new HttpClient();
            $client->setHost($host);
            $client->setPort($port);
            $client->addHeader(new HttpHeader('Connection', 'close'));
            $client->setMethod(new PostRequestMethod());
            $this->client = $client;
            $this->authkey = $authkey;

            $this->useragent = $useragent;
        }

        /**
         * Creates a ApiBukkit instance from a Server object
         *
         * @param Server $server the server
         * @return ApiBukkit the ApiBukkit instance for the given server
         */
        public static function getFromServer(Server $server)
        {
            return new self($server->getHost(), $server->getPort(), $server->getAuthKey());
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
            $params['authkey'] = $this->authkey;
            if ($this->useragent !== null)
            {
                $this->client->addHeader(new HttpHeader("apibukkit-useragent", $this->useragent));
            }
            $this->client->setTarget($path);
            $this->client->setRequestBody($this->client->generateQueryString($params));
            return $this->client->executeRequest();
        }
        
        public function request($controller, $action = null, array $params = array())
        {
            return $this->requestPath('/' . $controller . ($action !== null ? '/' . strval($action) : ''), $params);
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
    }
?>
