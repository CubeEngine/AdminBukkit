<?php
    $lang = Lang::instance('playerpopup');
    $player = trim(Request::get('player'));
    if ($player === '')
    {
        Router::instance()->redirectToPage('players', $lang['noplayer']);
    }
    $page = new Page('playerpopup', true);
    $page->assign('player', $player);
    $toolbar = new Toolbar($lang['playerinfos']);
    //$toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/playerpopup'));

    $design->setContentView($page);
?>
