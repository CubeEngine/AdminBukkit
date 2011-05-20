<?php
    error_reporting(-1);

    defined('DS')               or define('DS',             DIRECTORY_SEPARATOR);
    defined('BACKEND_PATH')     or define('BACKEND_PATH',   dirname(__FILE__));
    defined('INCLUDE_PATH')     or define('INCLUDE_PATH',   BACKEND_PATH . DS . 'includes');
    defined('TEMPLATE_PATH')    or define('TEMPLATE_PATH',  BACKEND_PATH . DS . 'templates');
    defined('PAGE_PATH')        or define('PAGE_PATH',      BACKEND_PATH . DS . 'pages');
    defined('CONFIG_PATH')      or define('CONFIG_PATH',    BACKEND_PATH . DS . 'configs');
    defined('LANG_PATH')        or define('LANG_PATH',      BACKEND_PATH . DS . 'language');
    defined('LOG_PATH')         or define('LOG_PATH',       BACKEND_PATH . DS . 'logs');

    function __autoload($classname)
    {
        static $classmap = array(
            'Template'                          => 'Template.php',
            'Design'                            => 'Design.php',
            'Config'                            => 'Config.php',
            'Minecraft'                         => 'Minecraft.php',
            'Router'                            => 'Router.php',
            'IView'                             => 'IView.php',
            'IFilter'                           => 'IFilter.php',
            'Registry'                          => 'Registry.php',
            'Page'                              => 'Page.php',
            'WhitespaceFilter'                  => 'WhitespaceFilter.php',
            'TidyFilter'                        => 'TidyFilter.php',
            'Toolbar'                           => 'Toolbar.php',
            'Router'                            => 'Router.php',
            'HttpClient'                        => 'Http/HttpClient.php',
            'HttpHeader'                        => 'Http/HttpHeader.php',
            'HttpCookie'                        => 'Http/HttpCookie.php',
            'AbstractHttpRequestMethod'         => 'Http/AbstractHttpRequestMethod.php',
            'AbstractHttpAuthentication'        => 'Http/AbstractHttpAuthentication.php',
            'BasicAuthentication'               => 'Http/AuthenticationMethods/BasicAuthentication.php',
            'GetRequestMethod'                  => 'Http/RequestMethods/GetRequestMethod.php',
            'PostRequestMethod'                 => 'Http/RequestMethods/PostRequestMethod.php',
            'OptionsRequestMethod'              => 'Http/RequestMethods/OptionsRequestMethod.php',
            'TraceRequestMethod'                => 'Http/RequestMethods/TraceRequestMethod.php',
            'HeadRequestMethod'                 => 'Http/RequestMethods/HeadRequestMethod.php',
            'SQLite'                            => 'SQLite.php',
            'AESCrypter'                        => 'AESCrypter.php',
            'User'                              => 'User.php',
            'Text'                              => 'Text.php',
            'ApiValidator'                      => 'ApiValidator.php',
            'SessIDFilter'                      => 'SessIDFilter.php',
            'Request'                           => 'Request.php',
            'Lang'                              => 'lang.php',
            'Logger'                            => 'Logger.php',
            'Statistics'                        => 'Statistics.php'
        );
        
        if (isset($classmap[$classname]))
        {
            require_once INCLUDE_PATH . DS . $classmap[$classname];
        }
    }
    
    function onError($errno, $errstr, $errfile, $errline, $errcontext)
    {
        if (error_reporting() == 0)
        {
            return;
        }
        $logger = Logger::instance('error');
        $errstr = strip_tags($errstr);
        $errfile = (isset($errfile) ? basename($errfile) : 'unknown');
        $errline = (isset($errline) ? $errline : '?');

        $errortype = '';
        switch ($errno)
        {
            case E_ERROR:
                $errortype = 'error';
                break;
            case E_WARNING:
                $errortype = 'warning';
                break;
            case E_NOTICE:
                $errortype = 'notice';
                break;
            case E_STRICT:
                $errortype = 'strict';
                break;
            case E_DEPRECATED:
                $errortype = 'deprecated';
                break;
            case E_RECOVERABLE_ERROR:
                $errortype = 'recoverable error';
                break;
            case E_USER_ERROR:
                $errortype = 'usererror';
                break;
            case E_USER_WARNING:
                $errortype = 'user warning';
                break;
            case E_USER_NOTICE:
                $errortype = 'user notice';
                break;
            case E_USER_DEPRECATED:
                $errortype = 'user deprecated';
                break;
            default:
                $errortype = 'unknown';
        }

        $logger->write(0, $errortype, '[' . $errfile . ':' . $errline . '] ' . $errstr);
        if (Config::instance('bukkitweb')->get('displayErrors', false))
        {
            echo "$errortype occurrered in [$errfile:$errline]:<br />\nMessage: $errstr<br />";
        }
    }
    
    function onException($e)
    {
        $logger = Logger::instance('error');
        $type = get_class($e);
        $logger->write(0, $type, '[' . basename($e->getFile()) . ':' . $e->getLine() . '] ' . $e->getMessage());

        if (Config::instance('bukkitweb')->get('displayErrors', false))
        {
            echo 'An uncaught ' . $type . " occurred!<br />\nMessage: " . $e->getMessage();
        }
    }
    
    set_error_handler('onError', -1);
    set_exception_handler('onException');

    session_name(Config::instance('bukkitweb')->get('sessionName', 'sid'));
    //session_set_cookie_params(Config::instance('bukkitweb')->get('sessionCookieLiftime', 3600));
    session_start();
?>
