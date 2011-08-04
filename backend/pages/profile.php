<?php
    $lang = Lang::instance('profile');
    $page = new Page('profile', true);
    $toolbar = new Toolbar($lang['profile']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_home'), './');
    $toolbar->setButton($lang['edit'], 'editprofile.html');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->assign('username', $_SESSION['user']->getName());
    $page->assign('email', $_SESSION['user']->getEmail());
    $page->assign('host', $_SESSION['user']->getServerAddress());
    $page->assign('port', $_SESSION['user']->getApiPort());
    $page->assign('pass', $_SESSION['user']->getApiPassword());
    $page->setContent(new Template('pages/profile'));
    
    $design->setContentView($page);
?>
