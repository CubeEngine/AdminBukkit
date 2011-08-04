<?php
    $lang = Lang::instance('players');
    $page = new Page('players', true);
    $page->assign('world', Request::get('world', ''));
    $toolbar = new Toolbar($lang['playerlist']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $toolbar->setButton($lang['refresh'], '#');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/players'));
    $page->setInfo($lang['pageinfo']);
    
    $design->setContentView($page);
?>