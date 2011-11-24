<?php
    import('View.View');

    /**
     *
     * @author CodeInfection
     */
    interface MainView extends View
    {
        public function getContent();
        public function setContent(View $content);
    }
?>
