<?php
    class ToolbarButton
    {
        public $id;
        public $name;
        public $attributes;

        public function __construct($id, $name, $target = null)
        {
            $this->id = $id;
            $this->name = $name;
            $this->attributes = array(
                'id' => 'toolbar_' . $id
            );
            if ($target !== null)
            {
                $this->attributes['href'] = $target;
            }
        }

        public function __toString()
        {
            return CHtml::tag('a', $this->attributes, $this->name);
        }

        public function setIcon($name)
        {
            $this->attributes['data-icon'] = $name;
        }

        public function setRelation($name)
        {
            $this->attributes['data-rel'] = $name;
        }

        public function setAttribute($name, $value = null)
        {
            if ($value === null)
            {
                unset($this->attributes[$name]);
            }
            else
            {
                $this->attributes[$name] = $value;
            }
        }

        public function setDataAttribute($name, $value = null)
        {
            $this->setAttribute('data-' . $name, $value);
        }
    }
?>
