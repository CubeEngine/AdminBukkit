<ul data-role="listview">
    <li data-role="list-divider"><?php echo Yii::t('downloads', 'Base plugin') ?></li>
    <li><a target="_blank" class="download" href="<?php echo $this->createUrl('downloads', array('file' => 'ApiBukkit.jar')) ?>">ApiBukkit</a></li>

    <li data-role="list-divider"><?php echo Yii::t('downloads', 'API plugins') ?></li>
    <li><a target="_blank" class="download" href="<?php echo $this->createUrl('downloads', array('file' => 'BasicApi.jar')) ?>">BasicApi</a></li>
</ul>
