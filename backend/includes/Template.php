<?php

    class Template implements IView
    {
        protected $file;
        protected $vars;
        protected $subtemplates;
        protected $postFilters;
        protected $views;
        protected $logger;
    
        public function __construct($file)
        {
            $tplpath = '';
            if (is_readable($file))
            {
                $tplpath =& $file;
            }
            elseif (is_readable(TEMPLATE_PATH . DS . $file . '.tpl.php'))
            {
                $tplpath = TEMPLATE_PATH . DS . $file . '.tpl.php';
            }
            else
            {
                throw new Exception('Template file not found or not readable!');
            }
            $this->file = $tplpath;
            
            $this->vars = array();
            $this->subtemplates = array();
            $this->postFilters = array();
            $this->views = array();
            $this->logger = Logger::instance('template');
        }
        
        public function __destruct()
        {}
        
        public function __toString()
        {
            try
            {
                return $this->render();
            }
            catch (Exception $e)
            {
                return $e->getMessage();
            }
        }
        
        public function render()
        {
            foreach ($this->vars as $name => $var)
            {
                if (preg_match('/(^\d|this)/', $name))
                {
                    $name = '_' . $name;
                }
                
                $$name = $var;
            }
            
            ob_start();
            
            include $this->file;
            
            $content = ob_get_clean();
            
            foreach ($this->postFilters as $filter)
            {
                $filter->execute($content);
            }
            
            return $content;
        }
        
        public function display()
        {
            echo $this->render();
        }
        
        public function subtemplateExists($tpl)
        {
            return isset($this->subtemplates[$tpl]);
        }
        
        protected function renderSubtemplate($tpl)
        {
            if ($this->subtemplateExists($tpl))
            {
                $this->logger->write(4, 'info', 'rendering the subtemplate ' . $tpl);
                /**
                 * @todo clone or reference ?
                 */
                //$tpl = clone $this->subtemplates[$tpl];
                $tpl =& $this->subtemplates[$tpl];
                /*****/
                
                $tpl->assignAssoc($this->vars);
                return $tpl->render();
            }
            else
            {
                $this->logger->write(1, 'error', 'template ' . $tpl . ' not found!');
                return '';
            }
        }
        
        protected function displaySubtemplate($tpl)
        {
            $this->logger->write(5, 'info', 'Displaying the subtemplate ' . $tpl);
            echo $this->renderSubtemplate($tpl);
        }
        
        protected function subTemplate($tpl)
        {
            $this->displaySubtemplate($tpl);
        }
        
        protected function renderTemplateFile($tplpath)
        {
            try
            {
                $tpl = new Template($tplpath);
                return $tpl->render();
            }
            catch(Exception $e)
            {
                $this->logger->write(1, 'error', 'template file ' . $tplpath . ' not found! (' . $e->getMessage() . ')');
                return '';
            }
        }
        
        protected function displayTemplateFile($tplPath)
        {
            echo $this->renderTemplateFile($tplPath);
        }
        
        public function addSubtemplate($name, Template $tpl)
        {
            $this->subtemplates[strval($name)] = $tpl;
            return $this;
        }
        
        public function addSubtemplates(array $names, array $tpls)
        {
            $limit = min(count($names), count($tpls));
            
            for ($i = 0; $i < $limit; $i++)
            {
                if ($tpls[$i] instanceof Template)
                {
                    $this->addSubtemplate($names[$i], $tpls[$i]);
                }
            }
            return $this;
        }
        
        public function &getSubtemplate($name)
        {
            if ($this->subtemplateExists($name))
            {
                return $this->subtemplates[$name];
            }
            else
            {
                return null;
            }
        }
        
        public function isAssigned($name)
        {
            return isset($this->vars[$name]);
        }
        
        public function assign($name, $value)
        {
            $this->vars[trim(strval($name))] = $value;
            return $this;
        }
        
        public function assignAssoc(array $map)
        {
            foreach ($map as $name => $value)
            {
                $this->assign($name, $value);
            }
            return $this;
        }
        
        public function getVar($name, $default = null)
        {
            $name = strval($name);
            if ($this->isAssigned($name))
            {
                return $this->vars[$name];
            }
            else
            {
                return $default;
            }
        }
        
        public function addPostFilter(IFilter $filter)
        {
            $this->postFilters[] = $filter;
            return $this;
        }
        
        public function getPostFilters()
        {
            return $this->postFilters;
        }
        
        public function clearPostFilters()
        {
            $this->postFilters = array();
            return $this;
        }

        public function viewExists($name)
        {
            return isset($this->views[$name]);
        }

        public function addView($name, IView $widget)
        {
            $this->views[strval($name)] = $widget;
            return $this;
        }

        public function addViewsAssoc(array $widgets)
        {
            foreach ($widgets as $name => $widget)
            {
                if ($widget instanceof IWidget)
                {
                    $this->views[strval($name)] = $widget;
                }
            }
            return $this;
        }

        public function &getView($name)
        {
            if ($this->viewExists($name))
            {
                return $this->views[$name];
            }
            else
            {
                return null;
            }
        }

        public function removeWidget($name)
        {
            unset($this->views[$name]);
            return $this;
        }
    }

?>
