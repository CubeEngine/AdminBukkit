<?php
    $page = new Page('about');
    $toolbar = new Toolbar('About');
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/about'));
    
    $design->setContentView($page);
?>
