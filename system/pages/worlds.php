<?php
    $lang = Lang::instance('worlds');
    $page = new Page('worlds', $lang['worlds'], true);
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         ->setButton($lang['refresh'], '#')
         ->setContent(new Template('pages/worlds'));
    
    $design->setContentView($page);
?>
