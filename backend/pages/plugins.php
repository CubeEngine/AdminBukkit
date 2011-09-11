<?php
    $lang = Lang::instance('plugins');
    $page = new Page('plugins', $lang['pluginlist'], true);
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         ->setButton($lang['refresh'], '#')
         ->setContent(new Template('pages/plugins'))
         ->setInfo($lang['info']);
    
    $design->setContentView($page);
?>
