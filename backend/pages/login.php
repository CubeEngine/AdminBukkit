<?php
    $lang = Lang::instance('login');
    if (User::loggedIn())
    {
        Router::redirectToPage('home', $lang['alreadyloggedin']);
    }

    $page = new Page('login');
    $page->assign('user', '')
         ->assign('langs', array_merge(array(Lang::getLanguage()), Lang::listLanguages()));
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $user = trim(Request::post('user'));
        $pass = Request::post('pass');
        $errors = array();
        if (empty($user))
        {
            $errors[] = $lang['user_missing'];
        }
        if (empty($pass))
        {
            $errors[] = $lang['pass_missing'];
        }
        if (!count($errors))
        {
            try
            {
                User::login(User::get($_POST['user'], $_POST['pass']));
                $_SESSION['cookies'] = (Request::post('nocookies') ? false : true);
                if (isset($_SESSION['referrer']))
                {
                    $referrer = $_SESSION['referrer'];
                    unset($_SESSION['referrer']);
                    Router::redirect($referrer);
                }
                else
                {
                    Router::redirectToPage('home', $lang['login_success']);
                }
            }
            catch (Exception $e)
            {
                switch ($e->getCode())
                {
                    case 1: // User does not exist
                    case 2: // Wrong password
                        $errors[] = $lang['login_failed'];
                        break;
                    case -1:
                    case 3:
                    case 4:
                        $errors[] = $lang['internalerror'];
                        break;
                }
            }
        }
        
        $page->assign('errors', $errors);
        $page->assign('user', $user);
    }
    
    $tpl = new Template('pages/login');
    $toolbar = new Toolbar($lang['login']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_home'), './');
    $toolbar->setButton($lang['registration'], 'register.html');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent($tpl);
    
    $design->setContentTpl($page);
?>
