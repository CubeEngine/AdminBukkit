<?php $this->beginContent('//layouts/main') ?>
<div id="<?php echo $this->id ?>" data-role="page" data-title="AdminBukkit - <?php echo $this->title ?>" data-theme="a">
    <div data-role="header">
        <?php echo $this->backButton ?>
        <h1><?php echo $this->title ?></h1>
        <?php echo $this->utilButton ?>
    </div>
    <?php $this->widget('MessageBox') ?>
    <div data-role="content" data-theme="c">
        <?php echo $content ?>
    </div>
    <div data-role="footer">
        Copyright © 2011 by <a href="http://code-infection.de" data-role="none" target="_blank">Code Infection</a>
    </div>
</div>
<?php $this->endContent() ?>