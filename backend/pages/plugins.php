<?php
    $lang = Lang::instance('plugins');
    $page = new Page('plugins', true);
    $toolbar = new Toolbar($lang['pluginlist']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $toolbar->setButton($lang['refresh'], '#');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/plugins'));
    $page->setInfo($lang['info']);
    
    $design->setContentTpl($page);
?>
