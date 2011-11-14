<?php
    import('Network.Http.HttpClient');

    final class OptionsRequestMethod extends HttpRequestMethod
    {
        public function __toString()
        {
            return 'OPTIONS';
        }

        public function getHeader(HttpClient $http)
        {
            $http->setConnectionKeepAlive(false);
            $headerLines = array();
            $headerLines[] = 'OPTIONS ' . $http->getFile() . ' HTTP/1.1';
            $headerLines[] = 'Host: ' . $http->getHost();
            $headerLines[] = 'Connection: close';

            return implode(HttpClient::LINE_ENDING, $headerLines);
        }

        public function content()
        {
            return true;
        }
    }
?>
