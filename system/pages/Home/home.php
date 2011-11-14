<?php
    $lang = Lang::instance('home');
    $page = new Page('home', $lang['home']);
    $page->setButton($lang['about'], $design->getLinkGenerator()->page('about'))
         ->setContent(new Template('pages/home'));
    
    $design->setContentView($page);
?>
