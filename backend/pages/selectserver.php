<?php
    $lang = Lang::instance('selectserver');
    $page = new Page('selectserver', $Lang['selectserver'], true);
    $page->setContent(new Template('pages/popups/selectserver'));
    
    $design->setContentView($page);
?>
