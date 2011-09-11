<?php
    $lang = Lang::instance('playerbanlist');
    $page = new Page('playerbanlist', $lang['title'], true);
    $page->setContent(new Template('pages/popups/playerbanlist'));

    $design->setContentView($page);
?>
