<?php
    $lang = Lang::instance('logout');
    $user = User::currentlyLoggedIn();
    if ($user)
    {
        $user->logout();
        Router::instance()->redirectToPage('home', $lang['logout_success']);
    }
    else
    {
        Router::instance()->redirectToPage('home', $lang['notloggedin']);
    }
?>
