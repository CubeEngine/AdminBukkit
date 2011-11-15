<?php
    /**
     * Abstract base class for a basic controller which provides basic functionality
     */
    abstract class BasicPage implements Controller
    {
        protected $design;
        protected $db;
        protected $session;
        protected $request;
        protected $response;
        
        public function __construct()
        {
            //$this->design = new Design();
            $this->db = Registry::get('database');
            $this->session =& Session::instance();
        }
        
        public function __destruct()
        {
            //$this->response->setContent($this->design->render());
        }
    }
?>
