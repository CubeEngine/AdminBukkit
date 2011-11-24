<?php
    $lang = Lang::instance('profile');
    $user = User::currentlyLoggedIn();

    $page = new Page('profile', $lang['profile'], true);
    //die('<script>alert("' . count($user->getServers()) . '")</script>');
    $page->setBack(Lang::instance('generic')->get('btn_home'))
         ->setButton($lang['edit'], $design->getLinkGenerator()->page('editprofile'))
         ->assign('username', $user->getName())
         ->assign('email', $user->getEmail())
         ->assign('currentserver', $user->getCurrentServer())
         ->assign('servers', $user->getServers())
         ->setContent(new Template('pages/profile'));
    
    $design->setContentView($page);
?>
