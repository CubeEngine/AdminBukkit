<?php
    $lang = Lang::instance('login');
    if (User::currentlyLoggedIn())
    {
        Router::instance()->redirectToPage('home', $lang['alreadyloggedin']);
    }

    $page = new Page('login', $lang['login']);
    $page->assign('id', '')
         ->assign('langs', array_unique(array_merge(array(Lang::getLanguage()), Lang::listLanguages())));
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $id = trim(Request::post('id'), ' ');
        $pass = Request::post('pass');
        $errors = array();
        if (empty($id))
        {
            $errors[] = $lang['id_missing'];
        }
        if (empty($pass))
        {
            $errors[] = $lang['pass_missing'];
        }
        if (!count($errors))
        {
            try
            {
                User::get($id)->login($pass);
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
            catch (ModelException $e)
            {
                switch ($e->getCode())
                {
                    case User::ERR_NOT_FOUND: // User does not exist
                        $errors[] = 'Benutzer nicht gefunden!';
                        break;
                    case User::ERR_WRONG_PASS: // Wrong password
                        $errors[] = $lang['login_failed'];
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
            $_SESSION['message'] = implode('<br>', $errors);
        }
        $page->assign('id', $id);
    }
    
    $tpl = new Template('pages/login');
    $page->setBack(Lang::instance('generic')->get('btn_home'), Router::instance()->getBasePath())
         ->setButton($lang['registration'], $design->getLinkGenerator()->page('register'))
         ->setContent($tpl);
    
    $design->setContentView($page);
?>
