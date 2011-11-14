<?php
    class DefaultLinkGenerator implements LinkGenerator
    {
        protected $base;

        public function __construct($base)
        {
            $this->base = $base;
        }

        public function page($page)
        {
            return $this->base . 'index.php/' . $page . '/';
        }

        public function res($resource)
        {
            return $this->base . 'res/' . $resource;
        }
    }
?>
