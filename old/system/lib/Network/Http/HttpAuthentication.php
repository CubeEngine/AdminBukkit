<?php
    import('Network.Http.HttpClient');

    interface HttpAuthentication
    {
        public abstract function __toString();
        public abstract function getAuthHeader(HttpClient $http);
    }
?>
