<?php
    import('Models.Lang');
    import('Models.Session');
    import('Database.DatabaseManager');
    import('View.Page');

    /**
     * Abstract base class for a basic controller which provides basic functionality
     */
    abstract class BasicPage extends Controller
    {
        protected $name;
        protected $authNeeded;
        protected $page;
        protected $db;
        protected $lang;
        protected $session;
        protected $request;
        protected $response;
        
        public function __construct($name, $authNeeded = false)
        {
            $this->name = $name;
            $this->lang = Lang::instance($name);
            //$this->design = new Design();
            $this->db = DatabaseManager::instance()->getDatabase();
            $this->session =& Session::instance();
        }

        public function preExecution()
        {
            $this->page = new Page();
        }

        public function postExecution()
        {
            //$this->response->setContent($this->design->render());
        }
    }
?>
