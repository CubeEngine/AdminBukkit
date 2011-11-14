<?php
    $lang = Lang::instance('searchserver');
    $page = new Page('searchserver', $lang['searchserver'], true);
    $page->setContent(new Template('pages/searchserver'));
    
    $design->setContentView($page);
?>
