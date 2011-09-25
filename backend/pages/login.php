<?php
    $lang = Lang::instance('login');
    if (User::loggedIn())
    {
        Router::instance()->redirectToPage('home', $lang['alreadyloggedin']);
    }

    $page = new Page('login', $lang['login']);
    $page->assign('user', '')
         ->assign('langs', array_unique(array_merge(array(Lang::getLanguage()), Lang::listLanguages())));
    
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
                if (isset($_SESSION['referrer']))
                {
                    $referrer = $_SESSION['referrer'];
                    unset($_SESSION['referrer']);
                    Router::instance()->redirect($referrer);
                }
                else
                {
                    Router::instance()->redirectToPage('home', $lang['login_success']);
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

        if (count($errors))
        {
            $_SESSION['message'] = implode('<br>', $errors);
        }
        $page->assign('user', $user);
    }
    
    $tpl = new Template('pages/login');
    $page->setBack(Lang::instance('generic')->get('btn_home'), Router::instance()->getBasePath())
         ->setButton($lang['registration'], $design->getLinkGenerator()->page('register'))
         ->setContent($tpl);
    
    $design->setContentView($page);
?>
