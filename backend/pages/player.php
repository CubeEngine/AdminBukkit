<?php
    $lang = Lang::instance('player');
    $player = trim(Request::get('player'));
    if ($player === '')
    {
        Router::redirectToPage('players', $lang['noplayer']);
    }
    $page = new Page('player', true);
    $page->assign('player', $player);
    $toolbar = new Toolbar($lang['playerinfos']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $toolbar->setButton($lang['refresh'], '#');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/player'));
    $page->setInfo($lang['info']);
    
    $design->setContentTpl($page);
?>
