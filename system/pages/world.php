<?php
    $lang = Lang::instance('world');
    $world = trim(Request::get('world'));
    if ($world === '')
    {
        Router::instance()->redirectToPage('worlds', $lang['noworld']);
    }
    $page = new Page('world', $lang['worldinfo']);
    $page->assign('world', Request::get('world'))
         ->setBack(Lang::instance('generic')->get('btn_back'))
         ->setButton($lang['refresh'], '#')
         ->setContent(new Template('pages/world'));
    
    $design->setContentView($page);
?>