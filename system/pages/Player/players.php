<?php
    $lang = Lang::instance('players');
    $page = new Page('players', $lang['playerlist'], true);
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         ->setButton($lang['refresh'], '#')
         ->setContent(new Template('pages/players'))
         ->setInfo($lang['pageinfo']);
    
    $design->setContentView($page);
?>