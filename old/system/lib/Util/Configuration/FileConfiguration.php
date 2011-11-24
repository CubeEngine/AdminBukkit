<?php
    import('Util.Configuration.Configuration');

    /**
     *
     */
    interface FileConfiguration extends Configuration
    {
        public function save();
        public function load($reload = false);
    }
?>
