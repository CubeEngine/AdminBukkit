<?php
    import('Debug.Logger');

    /**
     * 
     */
    class Debug
    {
        /**
         * teh error handler
         *
         * @param int $errno
         * @param string $errstr
         * @param string $errfile
         * @param int $errline
         * @param array $errcontext
         */
        public static function error_handler($errno, $errstr, $errfile, $errline, $errcontext)
        {
            if (error_reporting() == 0)
            {
                return;
            }
            $type = Debug::getErrorTypeStr($errno);
            $message = strip_tags($errstr);
            $file = (isset($errfile) ? $errfile : 'unknown');
            $line = (isset($errline) ? $errline : 'unknown');
            Debug::logError(
                $type,
                $message,
                $file,
                $line
            );
            if (Registry::get('debug.printErrors', false))
            {
                Debug::printError(
                    $type,
                    $message,
                    $file,
                    $line
                );
            }
        }

        public static function fatalerror_handler()
        {
            $error = error_get_last();
            if ($error)
            {
                Debug::error_handler($error['type'], $error['message'], $error['file'], $error['line'], array());
            }
        }

        /**
         * the exception handler
         *
         * @param Exception $e
         */
        public static function exception_handler($e)
        {
            if ($e instanceof LoggerException)
            {
                die('A LoggerException was not caught, ending the Script here!<br />Message: ' . $e->getMessage());
            }
            else
            {
                $type = get_class($e);
                $message = $e->getMessage();
                $file = $e->getFile();
                $line = $e->getLine();
                Debug::logError(
                    $type,
                    $message,
                    $file,
                    $line
                );
                
                if (Registry::get('debug.printErrors', false))
                {
                    Debug::printError(
                        $type,
                        $message,
                        $file,
                        $line
                    );
                }
            }
        }

        /**
         * Logs an error to the error log
         *
         * @param string $type the type of the error
         * @param string $message the error message
         * @param string $file the file the error occurred in
         * @param string $line the line the error occurred on
         */
        public static function logError($type, $message, $file, $line)
        {
            Logger::instance('error')->write(0, $type, '[' . basename($file) . ':' . $line . '] ' . $message);
        }

        /**
         * Logs a exception
         *
         * @param Exception $e the exception
         */
        public static function logException(Exception $e)
        {
            Debug::logError(get_class($e), $e->getMessage(), $e->getFile(), $e->getLine());
        }

        /**
         * Prints an error to the screen
         *
         * @param string $type the type of the error
         * @param string $message the error message
         * @param string $file the file the error occurred in
         * @param string $line the line the error occurred on
         */
        public static function printError($type, $message, $file, $line)
        {
            echo "<div><strong>$type</strong>: $message [$file:$line]</div>";
        }

        /**
         * Prints a exception
         *
         * @param Exception $e the exception
         */
        public static function printException(Exception $e)
        {
            Debug::printError(get_class($e), $e->getMessage(), $e->getFile(), $e->getLine());
        }

        /**
         * Returns the error type as a string
         *
         * @param int $errno the error ID
         * @return string error type
         */
        public static function getErrorTypeStr($errno)
        {
            $errortype = 'unknown';
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
            }
            return $errortype;
        }

        /**
         * scales the runtime of the given callback
         *
         * @param callback the funktion to scale
         * @param mixed[] the params to pass to the callback
         * @param &mixed the result of the callback
         * @return mixed the runtime or false on failure
         */
        public static function benchmark($callback, $params = array(), &$result = null)
        {
            if (is_callable($callback))
            {
                $start = microtime(true);
                $result = call_user_func_array($callback, $params);
                $end = microtime(true);
                return ($end - $start);
            }
            else
            {
                return false;
            }
        }
    }
?>
