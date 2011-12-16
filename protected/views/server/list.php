<ul data-role="listview">
<?php if (count($servers)): ?>
    <?php foreach ($servers as $server): ?>
        <?php if ($server): ?>
        <li>
            <a href="<?php echo $this->createUrl('server/view', array('id' => $server->getId())) ?>"><?php echo $server->getAlias() ?></a>
            <a href="<?php echo $this->createUrl('server/select', array('id' => $server->getId())) ?>" data-rel="dialog" data-icon="check"></a>
        </li>
        <?php endif ?>
    <?php endforeach ?>
<?php else: ?>
    <li><?php echo Yii::t('server', 'You have no servers registered, yet!') ?></li>
<?php endif ?>
</ul>
