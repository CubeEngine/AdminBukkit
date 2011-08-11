<?php
    $lang = Lang::instance('register');
    if (User::loggedIn())
    {
        Router::instance()->redirectToPage('home', $lang['alreadyregistered']);
    }
    
    $page = new Page('register');
    $page->assign('user', '')
         ->assign('email', '')
         ->assign('serveraddr', '')
         ->assign('apiport', '')
         ->assign('apipass', '');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $user = trim(Request::post('user'));
        $email = trim(Request::post('email'));
        $pass = Request::post('pass');
        $pass_repeat = Request::post('pass_repeat');
        $serveraddr = trim(Request::post('serveraddr'));
        $apiport = trim(Request::post('apiport'));
        $apipass = Request::post('apipass');
        
        $errors = array();
        if (empty($user))
        {
            $errors[] = $lang['user_missing'];
        }
        elseif (!preg_match('/^[\w\d-]{5,40}/i', $user))
        {
            $errors[] = $lang['user_invalid'];
        }
        elseif (User::exists($user))
        {
            $errors[] = $lang['user_alreadyexists'];
        }
        if (empty($email))
        {
            $errors[] = $lang['email_missing'];
        }
        elseif (!Text::is_email($email))
        {
            $errors[] = $lang['email_invalid'];
        }
        if (empty($pass))
        {
            $errors[] = $lang['pass_missing'];
        }
        elseif (empty($pass_repeat))
        {
            $errors[] = $lang['passr_missing'];
        }
        elseif ($pass !== $pass_repeat)
        {
            $errors[] = $lang['pass_dontmatch'];
        }
        if (empty($serveraddr))
        {
            $errors[] = $lang['serveraddr_missing'];
        }
        elseif (!ApiValidator::validHost($serveraddr))
        {
            $errors[] = $lang['serveraddr_invalidhost'];
        }
        if (empty($apiport))
        {
            $errors[] = $lang['apiport_missing'];
        }
        elseif (!preg_match('/^\d{2,5}$/', $apiport))
        {
            $errors[] = $lang['apiport_invalid'];
        }
        if (empty($apipass))
        {
            $errors[] = $lang['apipass_missing'];
        }
        if (!count($errors) && !ApiValidator::serverReachable($serveraddr, $apiport))
        {
            $errors[] = $lang['svr_unreachable'];
        }
        elseif (!count($errors) && !ApiValidator::validApiPass($serveraddr, $apiport, $apipass))
        {
            $errors[] = $lang['apipass_wrong'];
        }
        
        if (!count($errors))
        {
            try
            {
                User::addUser(
                    $user,
                    $pass,
                    $email,
                    $serveraddr,
                    $apiport,
                    $apipass
                );
                User::login(User::get($user, $pass));
                Router::instance()->redirectToPage('home', $lang['registersuccess']);
            }
            catch (Exception $e)
            {
                switch ($e->getCode())
                {
                    case -1:
                    case 3:
                    case 4:
                        $errors[] = $lang['internalerror'];
                        break;
                    case 5:
                        $errors[] = $lang['user_alreadyexists'];
                        break;
                }
            }
        }
        
        if (count($errors))
        {
            $page->assign('errors', $errors);
        }
        
        $page->assign('user', $user)
             ->assign('email', $email)
             ->assign('serveraddr', $serveraddr)
             ->assign('apiport', $apiport)
             ->assign('apipass', $apipass);
    }
    
    $toolbar = new Toolbar($lang['registration']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $toolbar->setButton($lang['login'], $design->getLinkGenerator()->page('login'));
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/register'));
    
    $design->setContentView($page);
?>
