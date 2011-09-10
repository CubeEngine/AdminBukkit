<?php
    $lang = Lang::instance('server');
    $page = new Page('server', $lang['serverinfos'], true);
    $page->setBack(Lang::instance('generic')->get('btn_home'))
         ->setButton($lang['reload'], '#')
         ->setContent(new Template('pages/server'));
    
    $design->setContentView($page);
?>
