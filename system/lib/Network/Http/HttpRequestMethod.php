<?php
    abstract class HttpRequestMethod
    {
        /**
         * @return string the uppercase name of the request method
         */
        public abstract function __toString();

        /**
         * Builds the whole request header for this request method
         *
         * @access public
         * @param HttpClient $http the current Http-object
         * @return string the header ready to sent
         */
        public abstract function getHeader(HttpClient $http);

        /**
         * @access public
         * @return bool whether the request method expects a response
         */
        public function content()
        {
            return false;
        }

        /**
         * @access public
         * @return bool whether the request method is able to handle file uploads
         */
        public function fileUpload()
        {
            return false;
        }

        /**
         * Builds the Cookie-header
         *
         * @param Http the current Http-object
         * @return string the Cookie-header
         */
        protected final function buildCookieHeader(HttpClient $http)
        {
            $headerStr = '';
            foreach ($http->getCookies() as $cookie)
            {
                if (is_object($cookie) && $cookie instanceof HttpCookie)
                {
                    if (!$http->isCookieValid($cookie))
                    {
                        continue;
                    }
                    $headerStr .= '; ' . $cookie->get('name') . '=' . $cookie->get('value');
                }
            }
            return 'Cookie: ' . substr($headerStr, 2);
        }
    }
?>
