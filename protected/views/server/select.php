<div>
    <ul data-role="listview" data-inset="true">
        <li>
            <?php if ($server): ?>
            <?php echo Yii::t('server', 'The server >>{server}<< was successfully selected', array('{server}' => $server->getAlias())) ?>
            <?php else: ?>
            <?php echo Yii::t('server', 'The server you tried to select does not exisr or does not belong to your') ?>
            <?php endif ?>
        </li>
    </ul>
</div>
