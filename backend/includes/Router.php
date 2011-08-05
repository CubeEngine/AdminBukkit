<?php
/**
 * Description of Router
 *
 * @author CodeInfection
 */
class Router
{
    private static $instance = null;

    protected $config;
    protected $page;
    protected $pagePath;
    protected $base;

    protected $linkgen;
    
    private function __construct()
    {
        $this->config = Config::instance('bukkitweb');
        $this->page = null;
        $this->pagePath = null;
        $this->route();
        $this->base = str_replace('\\', '', dirname($_SERVER['SCRIPT_NAME']));
        if ($this->base != '/')
        {
            $this->base .= '/';
        }
        if (Config::instance('bukkitweb')->get('mod_rewrite', false))
        {
            $this->linkgen = new ModRewriteLinkGenerator($this->base);
        }
        else
        {
            $this->linkgen = new DefaultLinkGenerator($this->base);
        }
    }

    /**
     * returns the singleton instance of the router
     *
     * @return Router the router
     */
    public static function instance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    protected function route()
    {
        $page = '';
        $defaultPage = $this->config->get('default', 'index');
        if (isset($_SERVER['PATH_INFO']) && trim($_SERVER['PATH_INFO']) !== '')
        {
            $page = rtrim(trim($_SERVER['PATH_INFO']), '/');
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
    
    public function redirect($url)
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
    
    public function redirectToPage($page, $msg = null)
    {
        $url = $this->linkgen->page($page);
        if ($msg !== null)
        {
            $url .= '?msg=' . urlencode(strval($msg));
        }
        $this->redirect($url);
    }
    
    public function redirectToLoginPage($msg = 'Login benötigt')
    {
        $_SESSION['referrer'] = $_SERVER['REQUEST_URI'];
        self::redirectToPage('login', $msg);
    }

    public function getBasePath()
    {
        return $this->base;
    }

    public function setLinkGenerator(LinkGenerator $linkgen)
    {
        $this->linkgen = $linkgen;
    }

    public function getLinkGenerator()
    {
        return $this->linkgen;
    }
}

?>
