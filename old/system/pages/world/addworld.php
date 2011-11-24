<?php
    $lang = Lang::instance('addworld');
    $page = new Page('addworld', $lang['createworld'], true);
    $page->setContent(new Template('pages/popups/addworld'));

    $design->setContentView($page);
?>
