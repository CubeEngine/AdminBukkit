<ul data-role="listview">
    <li>
        <?php echo Yii::t('plugin', 'Status') ?>:
        <span class="value">
            <?php if ($enabled): ?>
                <?php echo Yii::t('plugin', 'active') ?>
            <?php else: ?>
                <?php echo Yii::t('plugin', 'inactive') ?>
            <?php endif ?>
        </span>
    </li>
    <li title="<?php echo $fullName ?>">
        <?php echo Yii::t('plugin', 'Name') ?>:
        <span class="value"><?php echo $pluginName ?></span>
    </li>
    <li>
        <?php echo Yii::t('plugin', 'Version') ?>:
        <span class="value"><?php echo $version ?></span>
    </li>
    <?php if ($website !== null): ?>
    <li class="forward">
        <a href="<?php echo $website ?>" target="_blank">
            <?php echo Yii::t('plugin', 'Website') ?>:
            <span class="value"><?php echo $website ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if ($description !== null): ?>
    <li>
        <?php echo Yii::t('plugin', 'Description') ?>:<br>
        <?php echo $description ?>
    </li>
    <?php endif ?>
    <?php if ($authors !== null): ?>
    <li>
        <?php echo Yii::t('plugin', 'Authors') ?>
        <ul data-role="listview">
        <?php foreach ($authors as $author): ?>
            <li><?php echo $author ?></li>
        <?php endforeach ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if ($commands !== null): ?>
    <li>
        <?php echo Yii::t('plugin', 'Commands') ?>
        <ul data-role="listview" data-filter="true">
        <?php foreach ($commands as $command => $info): ?>
            <li>
                <?php echo $command ?>
                <ul data-role="listview">
                    <?php if ($info->usage): ?>
                    <li>
                        <?php echo Yii::t('plugin', 'Usage') ?>:
                        <span class="value"><?php echo str_replace('/<command>', '/' . $command, $info->usage) ?></span>
                    </li>
                    <?php endif ?>
                    <?php if ($info->description): ?>
                    <li>
                        <?php echo Yii::t('plugin', 'Description') ?>:
                        <span class="value"><?php echo $info->description ?></span>
                    </li>
                    <?php endif ?>
                </ul>
            </li>
        <?php endforeach ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if ($depend !== null): ?>
    <li>
        <?php echo Yii::t('plugin', 'Dependencies') ?>
        <ul data-role="listview">
        <?php foreach ($depend as $dependency): ?>
            <li><?php echo $dependency ?></li>
        <?php endforeach ?>
        </ul>
    </li>
    <?php endif ?>
    <li>
        <?php echo Yii::t('plugin', 'Datafolder') ?>:
        <span class="value" id="plugin_datafolder"><?php echo $dataFolder ?></span>
    </li>
</ul>