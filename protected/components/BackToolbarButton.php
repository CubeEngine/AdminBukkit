<?php
    class BackToolbarButton extends ToolbarButton
    {
        public function __construct($name = null, $target = null)
        {
            if ($name === null)
            {
                $name = Yii::t('generic', 'Back');
            }
            parent::__construct('back', $name, $target);
            $this->attributes['data-rel'] = 'back';
            $this->attributes['data-icon'] = 'back';
        }
    }
?>
