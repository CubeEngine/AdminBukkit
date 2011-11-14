<?php
    $lang = Lang::instance('addserver');
    $page = new Page('addserver', $lang['addserver'], true);
    $page->setContent(new Template('pages/popups/addserver'));

    $design->setContentView($page);
?>
