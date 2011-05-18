<?php
    $lang = Lang::instance('home');
    $page = new Page('home');
    $toolbar = new Toolbar($lang['home']);
    $toolbar->setButton($lang['about'], 'about.html');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/home'));
    $page->setInfo(new Template('generic/copyright'));
    
    $design->setContentTpl($page);
?>
