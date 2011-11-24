<?php
    $lang = Lang::instance('about');
    $page = new Page('about', $lang['about']);
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         ->setContent(new Template('pages/about'));
    
    $design->setContentView($page);
?>
