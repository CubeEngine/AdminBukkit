<?php
    class TidyFilter implements Filter
    {
        public function execute(&$string)
        {
            $tidy = tidy_parse_string($string, array(
                'indent' => true,
                'indent-spaces' => 4
            ), 'utf8');
            $tidy->cleanRepair();
            $string = strval($tidy);
        }
    }
?>
