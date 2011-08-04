<?php
    $lang = Lang::instance('world');
    if (!isset($_GET['world']) || trim($_GET['world']) === '')
    {
        Router::redirectToPage('worlds', $lang['noworld']);
    }
    $page = new Page('world');
    $toolbar = new Toolbar($lang['worldinfo']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $toolbar->setButton($lang['refresh'], '#');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/world'));
    $page->assign('world', Request::get('world'));
    
    $design->setContentView($page);
?>