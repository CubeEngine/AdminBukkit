<ul data-role="listview">
<?php if (count($servers)): ?>
    <?php foreach ($servers as $server): ?>
        <li><a href="<?php echo $this->createUrl('server/view', array('id' => $server->getId())) ?>"><?php echo $server->getAlias() ?></a></li>
    <?php endforeach ?>
<?php else: ?>
    <li><?php echo Yii::t('server', 'You have no servers registered, yet!') ?></li>
<?php endif ?>
</ul>
