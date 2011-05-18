<?php
    $lang = Lang::instance('worlds');
    $page = new Page('worlds', true);
    $toolbar = new Toolbar($lang['worlds']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $toolbar->setButton($lang['refresh'], '#');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/worlds'));
    
    $design->setContentTpl($page);
?>
