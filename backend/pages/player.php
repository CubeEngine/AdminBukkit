<?php
    $lang = Lang::instance('player');
    $player = trim(Request::get('player'));
    if ($player === '')
    {
        Router::instance()->redirectToPage('players', $lang['noplayer']);
    }
    $page = new Page('player', $lang['playerinfos'], true);
    $page->assign('player', $player)
         ->setBack(Lang::instance('generic')->get('btn_back'))
         ->setButton($lang['refresh'], '#')
         ->setContent(new Template('pages/player'))
         ->setInfo($lang['info']);
    
    $design->setContentView($page);
?>
