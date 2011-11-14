<?php
    final class PostRequestMethod extends AbstractHttpRequestMethod
    {
        public function __toString()
        {
            return 'POST';
        }

        public function getHeader(HttpClient $http)
        {
            $requestBody = $http->getRequestBody();
            $headerLines = array();
            $headerLines[] = 'POST ' . $http->getFile() . ' HTTP/1.1';
            $headerLines[] = 'Host: ' . $http->getHost();
            $headerLines[] = 'Content-type: application/x-www-form-urlencoded';
            $headerLines[] = 'Content-Length: ' . strlen($requestBody);
            foreach ($http->getHeaders() as $index => $header)
            {
                if ($index == 'connection')
                {
                    if (strcasecmp($header->value, 'keep-alive') === 0)
                    {
                        $http->setConnectionKeepAlive(true);
                    }
                    else
                    {
                        $http->setConnectionKeepAlive(false);
                    }
                }
                $headerLines[] = strval($header);
            }
            if ($http->countCookies() > 0)
            {
                $headerLines[] = $this->buildCookieHeader($http);
            }
            if ($http->getAuthUse())
            {
                $headerLines[] = $http->getAuthMethod()->getAuthHeader($http);
            }
            $headerLines[] = '';
            $headerLines[] = $requestBody;

            return implode(HttpClient::LINE_ENDING, $headerLines);
        }

        public function content()
        {
            return true;
        }

        public function fileUpload()
        {
            return true;
        }
    }
?>
