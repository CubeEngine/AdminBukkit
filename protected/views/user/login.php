<div>
    <?php $form = $this->beginWidget('CActiveForm') ?>
    
    <?php echo $form->label($formModel, 'id') ?>
    <?php echo $form->textField($formModel, 'id') ?>
    
    <?php echo $form->label($formModel, 'password') ?>
    <?php echo $form->passwordField($formModel, 'password') ?>
    
    <?php echo $form->label($formModel, 'nocookies') ?>
    <?php echo $form->checkBox($formModel, 'nocookies') ?>
    
    <?php echo CHtml::submitButton(Yii::t('login', 'Login')) ?>
    
    <?php $this->endWidget() ?>
</div>
