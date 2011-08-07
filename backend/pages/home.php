<?php
    $lang = Lang::instance('home');
    $page = new Page('home');
    $toolbar = new Toolbar($lang['home']);
    $toolbar->setButton($lang['about'], $design->getLinkGenerator()->page('about'));
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/home'));
    
    $design->setContentView($page);
?>
