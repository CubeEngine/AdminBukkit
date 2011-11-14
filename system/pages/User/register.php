<?php
    $lang = Lang::instance('register');
    if (User::currentlyLoggedIn())
    {
        Router::instance()->redirectToPage('home', $lang['alreadyregistered']);
    }
    
    $page = new Page('register', $lang['registration']);
    $page->assign('user', '')
         ->assign('email', '');
    
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
        elseif (!preg_match('/^[a-z][\w\d-]*$/i', $user))
        {
            $errors[] = $lang['user_invalid'];
        }
        elseif (strlen($user) < 5)
        {
            $errors[] = $lang['user_tooshort'];
        }
        elseif (strlen($user) > 40)
        {
            $errors[] = $lang['user_toolong'];
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
        
        if (!count($errors))
        {
            try
            {
                User::createUser($user, $pass, $email)->login($pass);
                Router::instance()->redirectToPage('home', $lang['registersuccess']);
            }
            catch (SimpleException $e)
            {
                switch ($e->getCode())
                {
                    case User::ERR_NAME_USED:
                        $errors[] = $lang['user_alreadyexists'];
                        break;
                    case User::ERR_EMAIL_USED:
                        $errors[] = $lang['email_alreadyused'];
                        break;
                }
            }
            catch (Exception $e)
            {
                onException($e, true);
                $errors[] = $lang['internalerror'];
            }
        }
        
        if (count($errors))
        {
            $_SESSION['message'] = '- ' . implode("<br>- ", $errors);
        }
        
        $page->assign('user', $user)
             ->assign('email', $email);
    }
    
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         ->setButton($lang['login'], $design->getLinkGenerator()->page('login'))
         ->setContent(new Template('pages/register'));
    
    $design->setContentView($page);
?>
