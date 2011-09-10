<?php
    $lang = Lang::instance('playerpopup');
    $player = trim(Request::get('player'));
    if ($player === '')
    {
        Router::instance()->redirectToPage('players', $lang['noplayer']);
    }
    $page = new Page('playerpopup', true);
    $page->assign('player', $lang['playerinfos'], $player)
    //     ->setBack(Lang::instance('generic')->get('btn_back'));
         ->setContent(new Template('pages/playerpopup'));

    $design->setContentView($page);
?>
