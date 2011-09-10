<?php
    $lang = Lang::instance('register');
    if (User::loggedIn())
    {
        Router::instance()->redirectToPage('home', $lang['alreadyregistered']);
    }
    
    $page = new Page('register', $lang['registration']);
    $page->assign('user', '')
         ->assign('email', '')
         ->assign('serveraddr', '')
         ->assign('apiport', '6561')
         ->assign('apiauthkey', '');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $user = trim(Request::post('user'));
        $email = trim(Request::post('email'));
        $pass = Request::post('pass');
        $pass_repeat = Request::post('pass_repeat');
        $serveraddr = trim(Request::post('serveraddr'));
        $apiport = trim(Request::post('apiport'));
        $apiauthkey = Request::post('apipass');
        
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
        if (empty($apiauthkey))
        {
            $errors[] = $lang['apiauthkey_missing'];
        }
        if (!count($errors) && !ApiValidator::serverReachable($serveraddr, $apiport))
        {
            $errors[] = $lang['svr_unreachable'];
        }
        elseif (!count($errors) && !ApiValidator::validApiPass($serveraddr, $apiport, $apiauthkey))
        {
            $errors[] = $lang['apiauthkey_wrong'];
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
                    $apiauthkey
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
             ->assign('apiauthkey', $apiauthkey);
    }
    
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         ->setButton($lang['login'], $design->getLinkGenerator()->page('login'))
         ->setContent(new Template('pages/register'));
    
    $design->setContentView($page);
?>
