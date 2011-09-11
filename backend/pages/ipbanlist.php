<?php
    $lang = Lang::instance('ipbanlist');
    $page = new Page('ipbanlist', $lang['title'], true);
    $page->setContent(new Template('pages/popups/ipbanlist'));

    $design->setContentView($page);
?>
