<?php
    $lang = Lang::instance('editprofile');
    $registerLang = Lang::instance('register');
    $page = new Page('editprofile', true);
    $page->assign('user',       $_SESSION['user']->getName())
         ->assign('email',      $_SESSION['user']->getEmail())
         ->assign('serveraddr', $_SESSION['user']->getServerAddress())
         ->assign('apiport',    $_SESSION['user']->getApiPort())
         ->assign('apipass',    $_SESSION['user']->getApiPassword());
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $user = trim(Request::post('user'));
        $email = trim(Request::post('email'));
        $pass = Request::post('pass');
        $pass_repeat = Request::post('pass_repeat');
        $serveraddr = trim(Request::post('serveraddr'));
        $apiport = trim(Request::post('apiport'));
        $apipass = Request::post('apipass');
        
        $passwordSet = false;
        $errors = array();
        if (empty($user))
        {
            $errors[] = $registerLang['user_missing'];
        }
        elseif (!preg_match('/^[\w\d-]{5,40}/i', $user))
        {
            $errors[] = $registerLang['user_invalid'];
        }
        if (empty($email))
        {
            $errors[] = $registerLang['email_missing'];
        }
        elseif (!Text::is_email($email))
        {
            $errors[] = $registerLang['email_invalid'];
        }
        if (empty($pass))
        {
            $errors[] = $registerLang['pass_missing'];
        }
        elseif (empty($pass_repeat))
        {
            $errors[] = $registerLang['passr_missing'];
        }
        elseif ($pass !== $pass_repeat)
        {
            $errors[] = $registerLang['pass_dontmatch'];
        }
        if (empty($serveraddr))
        {
            $errors[] = $registerLang['serveraddr_missing'];
        }
        elseif (!ApiValidator::validHost($serveraddr))
        {
            $errors[] = $registerLang['serveraddr_invalidhost'];
        }
        if (empty($apiport))
        {
            $errors[] = $registerLang['apiport_missing'];
        }
        elseif (!preg_match('/^\d{2,5}$/', $apiport))
        {
            $errors[] = $registerLang['apiport_invalid'];
        }
        if (empty($apipass))
        {
            $errors[] = $registerLang['apipass_missing'];
        }
        if (!count($errors) && !ApiValidator::serverReachable($serveraddr, $apiport))
        {
            $errors[] = $registerLang['svr_unreachable'];
        }
        elseif (!count($errors) && !ApiValidator::validApiPass($serveraddr, $apiport, $apipass))
        {
            $errors[] = $registerLang['apipass_wrong'];
        }
        
        if (!count($errors))
        {
            try
            {
                User::updateUser(
                    $_SESSION['user']->getName(),
                    $user,
                    $pass,
                    $email,
                    $serveraddr,
                    $apiport,
                    $apipass
                );
                User::logout();
                Router::redirectToPage('home', $lang['edit_success']);
            }
            catch (Exception $e)
            {
                switch ($e->getCode())
                {
                    case -1:
                    case 3:
                    case 4:
                        $errors[] = $registerLang['internalerror'];
                        break;
                    case 5:
                        $errors[] = $registerLang['user_alreadyexists'];
                        break;
                }
            }
        }
        
        if (count($errors))
        {
            $page->assign('errors', $errors);
        }
        
        $page->assign('user', $user);
        $page->assign('email', $email);
        $page->assign('serveraddr', $serveraddr);
        $page->assign('apiport', $apiport);
        $page->assign('apipass', $apipass);
    }
    
    $toolbar = new Toolbar($lang['edit']);
    $toolbar->setBack($lang['profile'], 'profile.html');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/editprofile'));
    
    $design->setContentTpl($page);
?>
