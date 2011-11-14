<?php
    class ModRewriteLinkGenerator extends DefaultLinkGenerator implements LinkGenerator
    {
        public function __construct($base)
        {
            parent::__construct($base);
        }

        public function page($page)
        {
            return $this->base . $page . '/';
        }
    }
?>
