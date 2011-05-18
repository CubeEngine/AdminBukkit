<?php
    /**
     *
     */
    class History implements Serializable
    {
        protected $stack;
        protected $size;

        public function __construct(array $stack = null)
        {
            if ($stack === null)
            {
                $this->stack = array();
                $this->size = 0;
            }
            else
            {
                $this->stack = array_values($stack);
                $this->size = count($this->stack);
            }
        }

        public function push($value)
        {
            if ($value !== $this->top())
            {
                $this->size = array_push($this->stack, $value);
            }
            return $this;
        }

        public function pop()
        {
            if ($this->size > 0)
            {
                $this->size--;
            }
            return array_pop($this->stack);
        }

        public function top()
        {
            if (isset($this->stack[$this->size - 1]))
            {
                return $this->stack[$this->size - 1];
            }
            else
            {
                return null;
            }
        }

        public function size()
        {
            return $this->size;
        }
        
        public function isEmpty()
        {
            return ($this->size == 0);
        }
        
        public function getStack()
        {
            return $this->stack;
        }
        
        
        public function serialize()
        {
            return serialize(array($this->stack, $this->size));
        }
        public function unserialize($serialized)
        {
            $data = unserialize($serialized);
            $this->stack = $data[0];
            $this->size = $data[1];
        }
    }
?>
