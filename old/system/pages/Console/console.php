<?php
    $lang = Lang::instance('console');
    $page = new Page('console', $lang['consoleview'], true);
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         ->setButton($lang['disable_refreshing'], '#')
         ->setContent(new Template('pages/console'));

    $design->setContentView($page);
?>
