<?php
    $lang = Lang::instance('server');
    $page = new Page('server', true);
    $toolbar = new Toolbar($lang['serverinfos']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_home'), './');
    $toolbar->setButton($lang['reload'], '#');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/server'));
    
    $design->setContentTpl($page);
?>
