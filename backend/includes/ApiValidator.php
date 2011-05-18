<?php
    class ApiValidator
    {
        public static function validHost($host)
        {
            $ip = gethostbyname($host);
            return ((bool)preg_match('/^\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}$/', $ip));
        }
        
        public static function serverReachable($host, $port, $timeout = 2)
        {
            $h = @fsockopen($host, intval($port), $errno, $errstr, $timeout);
            if ($h === false)
            {
                return false;
            }
            @fclose($h);
            return true;
        }
        
        public static function validApiPass($host, $port, $pass)
        {   
            $target = "http://$host:$port/pass/";
            $http = new HttpClient();
            $http->setTarget($target);
            $http->setRequestBody($http->generateQueryString(array('password' => $pass)));
            $http->addHeader(new HttpHeader('Connection', 'close'));
            return ($http->executeRequest(new PostRequestMethod()) == 204);
        }
    }
?>
