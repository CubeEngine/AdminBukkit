<?php
    $lang = Lang::instance('playerpopup');
    $player = trim(Request::get('player'));
    if ($player === '')
    {
        Router::instance()->redirectToPage('players', $lang['noplayer']);
    }
    $page = new Page('playerpopup', $player, true);
    $page->assign('player', $player)
         ->setContent(new Template('pages/popups/player'));

    $design->setContentView($page);
?>
