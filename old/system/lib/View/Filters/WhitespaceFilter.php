<?php

    class WhitespaceFilter implements Filter
    {
        public function execute(&$string)
        {
            $string = preg_replace(array('/>\s+/', '/\s+</', "/\r\n/"), array('>', '<', "\n"), $string);
        }
    }

?>
