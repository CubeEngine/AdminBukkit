<?php
    import('Util.Registry');
    import('Debug.LoggerException');
    
    /**
     * 
     */
    class Logger
    {
        /**
         * the loglevel which controls the logger
         *
         * @var int
         */
        protected static $loglevel = 5;

        /**
         * Stores the Logger instances
         *
         * @var Logger[]
         */
        private static $instances = array();

        /**
         * the file handle of the log
         *
         * @var resource
         */
        protected $fhandle;

        /**
         * the name of the log
         *
         * @var string
         */
        protected $logname;

        /**
         * the path of the lof file
         *
         * @var string
         */
        protected $filepath;

        /**
         * the file mode the log gets opened with
         *
         * @var string
         */
        protected $fmode;

        /**
         * true if there was something written to the log file
         *
         * @var bool
         */
        protected $sthWritten;

        /**
         * initiates the Log object
         *
         * @param string $logname the filename for the log
         */
        private function __construct($logfile)
        {
            $path = Registry::get('paths.logs') . DS . $logfile . '.log';
            $writable = (file_exists($path) && is_writable($path)) || is_writable(dirname($path));
            if (!$writable)
            {
                throw new LoggerException('the logfile is not writable!', 401);
            }
            $this->sthWritten = false;
            $this->filepath = $path;
            $this->fmode = 'ab';
        }

        /**
         * closes the log-file
         */
        public function __destruct()
        {
            if ($this->sthWritten)
            {
                $this->write(0, 'Logger', '----------| Log closed |----------');
                @fclose($this->fhandle);
            }
        }

        private function __clone()
        {}

        /**
         * Returns a Logger instance
         *
         * @param string $logfile the log filename
         * @return Logger the logger
         */
        public static function instance($logfile)
        {
            if (!isset(self::$instances[$logfile]))
            {
                self::$instances[$logfile] = new self($logfile);
            }
            return self::$instances[$logfile];
        }

        /**
         * opens the log file if something was written
         */
        private function open()
        {
            if (!$this->sthWritten)
            {
                $this->sthWritten = true;
                $this->fhandle = @fopen($this->filepath, $this->fmode);
                if ($this->fhandle === false)
                {
                    throw new LoggerException('Could not open logfile "' . $this->logfile . '" for writing! Check file permissions!');
                }
                $this->write(0, 'Logger', '----------> Log opened <----------');
            }
        }

        /**
         * writes a line into the log file
         *
         * @param int $debugLevel the debug level to print at
         * @param string $entryType the type of the log entry
         * @param string $message the message/text of the entry
         */
        public function write($logLevel, $entryType, $message)
        {
            if (self::$loglevel >= $logLevel)
            {
                $this->open();
                $timestamp = date('d.m.y H:i:s');
                $message = str_replace("\n", ' ', $message);
                $message = str_replace("\r", ' ', $message);
                flock($this->fhandle, LOCK_EX);
                @fwrite($this->fhandle, "[$timestamp][$entryType] $message\n");
                flock($this->fhandle, LOCK_UN);
            }
        }

        /**
         * Returns the log level
         *
         * @return int the log level
         */
        public static function getLogLevel()
        {
            return self::$loglevel;
        }

        /**
         * Sets the log level
         *
         * @param int $level the log level to set
         */
        public static function setLogLevel($level)
        {
            if ($level >= 0 || $level <= 5)
            {
                self::$loglevel = $level;
            }
        }
    }
?>
