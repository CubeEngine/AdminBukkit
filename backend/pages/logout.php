<?php
    $lang = Lang::instance('logout');
    if (User::loggedIn())
    {
        User::logout();
        Router::instance()->redirectToPage('home', $lang['logout_success']);
    }
    else
    {
        Router::instance()->redirectToPage('home', $lang['notloggedin']);
    }
?>
