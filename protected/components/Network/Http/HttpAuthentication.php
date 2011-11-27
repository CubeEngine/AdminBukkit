<?php
    interface HttpAuthentication
    {
        public function __toString();
        public function getAuthHeader(HttpClient $http);
    }
?>
