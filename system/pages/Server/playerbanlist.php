<?php
    $lang = Lang::instance('playerbanlist');
    $page = new Page('playerbanlist', $lang['title'], true);
    $page->setContent(new Template('pages/popups/playerbanlist'));

    $page->setButton($lang['addban'], '#');

    $design->setContentView($page);
?>
