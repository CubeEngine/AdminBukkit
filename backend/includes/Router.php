<?php
/**
 * Description of Router
 *
 * @author CodeInfection
 */
class Router
{
    protected $config;
    protected $page;
    protected $pagePath;
    
    public function __construct()
    {
        $this->config = Config::instance('bukkitweb');
        $this->page = null;
        $this->pagePath = null;
        $this->route();
    }
    
    protected function route()
    {
        $page = '';
        $defaultPage = $this->config->get('default', 'index');
        if (isset($_SERVER['PATH_INFO']) && trim($_SERVER['PATH_INFO']) !== '')
        {
            $page = trim($_SERVER['PATH_INFO']);
        }
        else
        {
            $page =& $defaultPage;
        }

        $path = PAGE_PATH . DS;
        if (file_exists($path . $page . '.php'))
        {
            $this->page = $page;
            $this->pagePath = $path . $page . '.php';
        }
        elseif (file_exists($path . $defaultPage . '.php'))
        {
            $this->page = $defaultPage;
            $this->pagePath = $path . $defaultPage . '.php';
            $_GET['msg'] = urlencode('Die angeforderte Seite existiert nicht!');
        }
        else
        {
            throw new Exception('FUCK OFF!');
        }
    }
    
    public function getPage()
    {
        return $this->page;
    }
    
    public function getPagePath()
    {
        return $this->pagePath;
    }
    
    public static function redirect($url)
    {
        $sessString = session_name() . '=' . session_id();
        if (!preg_match('/^https?:\/\//i', $url) && !preg_match('/' . $sessString . '/i', $url) && !Request::session('cookies'))
        {
            $url .= (preg_match('/\?/', $url) ? '&' : '?') . $sessString;
        }
        header('Location: ' . $url);
        @ob_end_clean();
        die();
    }
    
    public static function redirectToPage($page, $msg = null)
    {
        $url = $page . '.html';
        if ($msg !== null)
        {
            $url .= '?msg=' . urlencode(strval($msg));
        }
        self::redirect($url);
    }
    
    public static function redirectToLoginPage($msg = 'Login benötigt')
    {
        $_SESSION['referrer'] = $_SERVER['REQUEST_URI'];
        self::redirectToPage('login', $msg);
    }
}

?>
