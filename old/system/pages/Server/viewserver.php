<?php
    $lang = Lang::instance('viewserver');
    $user = User::currentlyLoggedIn();
    $server = $user->getCurrentServer();

    $page = new Page('viewserver', $lang['viewserver'], true);
    $page->setBack(Lang::instance('generic')->get('btn_home'))
         ->setButton($lang['edit'], $design->getLinkGenerator()->page('editserver'))
         ->assign('alias',      $server->getAlias())
         ->assign('host',       $server->getHost())
         ->assign('port',       $server->getPort())
         ->assign('authkey',    $server->getAuthKey())
         ->assign('owner',      User::get($server->getOwner()))
         ->assign('members',    $server->getMembers())
         ->setContent(new Template('pages/editserver'));
    
    $design->setContentView($page);
?>
