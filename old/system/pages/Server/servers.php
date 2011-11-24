<?php
    $lang = Lang::instance('servers');
    $page = new Page('servers', $lang['servers'], true);
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         //->setButton($lang['refresh'], '#')
         ->setContent(new Template('pages/servers'));
    
    $design->setContentView($page);
?>
