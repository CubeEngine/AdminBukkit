<?php
    $lang = Lang::instance('logout');
    if (User::loggedIn())
    {
        User::logout();
        Router::redirectToPage('home', $lang['logout_success']);
    }
    else
    {
        Router::redirectToPage('home', $lang['notloggedin']);
    }
?>
