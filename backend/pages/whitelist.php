<?php
    $lang = Lang::instance('whitelist');
    $page = new Page('whitelist', $lang['title'], true);
    $page->setContent(new Template('pages/popups/whitelist'));

    $design->setContentView($page);
?>
