<?php
    $lang = Lang::instance('profile');
    $page = new Page('profile', $lang['profile'], true);
    $page->setBack(Lang::instance('generic')->get('btn_home'))
         ->setButton($lang['edit'], $design->getLinkGenerator()->page('editprofile'))
         ->assign('username', $_SESSION['user']->getName())
         ->assign('email', $_SESSION['user']->getEmail())
         ->assign('host', $_SESSION['user']->getServerAddress())
         ->assign('port', $_SESSION['user']->getApiPort())
         ->assign('pass', $_SESSION['user']->getApiAuthKey())
         ->setContent(new Template('pages/profile'));
    
    $design->setContentView($page);
?>
