<?php
    $lang = Lang::instance('console');
    $page = new Page('console', true);
    $toolbar = new Toolbar($lang['consoleview']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $toolbar->setButton($lang['disable_refreshing'], '#');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/console'));
    //$page->setInfo();

    $design->setContentView($page);
?>
