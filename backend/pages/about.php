<?php
    $lang = Lang::instance('about');
    $page = new Page('about', $lang['about']);
    $page->setBack(Lang::instance('generic')->get('btn_back'));
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/about'));
    
    $design->setContentView($page);
?>
