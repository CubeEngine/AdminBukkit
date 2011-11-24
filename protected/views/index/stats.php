<ul data-role="listview">
<?php if (count($userStats)): ?>
    <li data-role="divider" data-theme="e"><?php echo Yii::t('stats', 'User statistics') ?></li>
    <?php foreach ($userStats as $stat):  ?>
        <?php if (isset($messages[$stat['index']])): ?>
            <li><?php echo Yii::t('stats', $messages[$stat['index']], array('{count}' => $stat['value'])) ?></li>
        <?php endif?>
    <?php endforeach ?>
<?php endif ?>
<?php if (count($apiSuccess)): ?>
    <li data-role="divider" data-theme="e"><?php echo Yii::t('stats', 'API statistics') ?></li>
    <?php foreach ($apiSuccess as $stat):  ?>
        <?php if (isset($messages[$stat['index']])): ?>
            <li><?php echo Yii::t('stats', $messages[$stat['index']], array('{count}' => $stat['value'])) ?></li>
        <?php endif?>
    <?php endforeach ?>
<?php endif ?>
<?php if ($apiFailCount): ?>
<li><?php Yii::t('stats', '{failcount} Requests have failed.', array('{failcount}' => $apiFailCount)) ?></li>
<?php endif ?>
<?php if (count($dlStats)): ?>
    <li data-role="divider" data-theme="e"><?php $lang->downloads ?></li>
    <?php foreach ($dlStats as $file):  ?>
        <li><?php
            Yii::t('stats', 'The file "{name}" has been downlaoded {count} times.', array(
                '{name}' => $file['index'],
                '{count}' => $file['value'])
            )
        ?></li>
    <?php endforeach ?>
</ul>
<?php endif ?>