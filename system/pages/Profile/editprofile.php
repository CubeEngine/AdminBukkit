<?php
    $lang = Lang::instance('editprofile');
    $registerLang = Lang::instance('register');
    $user = User::currentlyLoggedIn();
    $page = new Page('editprofile', $lang['edit'], true);
    $page->assign('user',       $user->getName())
         ->assign('email',      $user->getEmail());
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $name = trim(Request::post('user'));
        $email = trim(Request::post('email'));
        $pass = Request::post('pass');
        $pass_repeat = Request::post('pass_repeat');
        
        $passwordSet = false;
        $errors = array();
        if (empty($name))
        {
            $errors[] = $registerLang['user_missing'];
        }
        elseif (!preg_match('/^[a-z][\w\d-]*$/i', $name))
        {
            $errors[] = $registerLang['user_invalid'];
        }
        elseif (strlen($name) < 5)
        {
            $errors[] = $registerLang['user_tooshort'];
        }
        elseif (strlen($name) > 40)
        {
            $errors[] = $registerLang['user_toolong'];
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
        
        if (!count($errors))
        {
            try
            {
                $user->update(
                    $name,
                    $pass,
                    $email,
                    $user->getServers()
                );
                $user->logout();
                Router::instance()->redirectToPage('home', $lang['edit_success']);
            }
            catch (ModelException $e)
            {
                switch ($e->getCode())
                {
                    case User::ERR_NAME_USED:
                        $errors[] = $registerLang['user_alreadyexists'];
                        break;
                }
            }
            catch (Exception $e)
            {
                onException($e, true);
                $errors[] = $registerLang['internalerror'];
            }
        }
        
        if (count($errors))
        {
            $_SESSION['message'] = implode("<br>", $errors);
        }
        
        $page->assign('user', $user)
             ->assign('email', $email);
    }
    
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         ->setContent(new Template('pages/editprofile'));
    
    $design->setContentView($page);
?>
