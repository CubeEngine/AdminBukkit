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
        
        public static function validApiPass($host, $port, $authkey)
        {
            $api = new ApiBukkit($host, $port, $authkey);
            $response = $api->request('validate', 'authkey');
            return ($response->getStatus() == 204);
        }
    }
?>
