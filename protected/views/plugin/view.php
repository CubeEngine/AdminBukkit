<ul data-role="listview">
    <li>
        <?php $lang->status ?>:
        <span class="value">
            <?php if ($enabled): ?>
                <?php echo Yii::t('plugin', 'active') ?>
            <?php else: ?>
                <?php echo Yii::t('plugin', 'inactive') ?>
            <?php endif ?>
        </span>
    </li>
    <li title="<?php echo $fullName ?>"><?php $lang->name ?>: <span class="value"><?php echo $pluginName ?></span></li>
    <li><?php $lang->version ?>: <span class="value"><?php echo $version ?></span></li>
    <?php if ($website !== null): ?>
    <li class="forward"><a href="<?php echo $website ?>" target="_blank"><?php $lang->website ?>: <span class="value"><?php echo $website ?></span></a></li>
    <?php endif ?>
    <?php if ($description !== null): ?>
    <li><?php $lang->description ?>:<br><?php echo $description ?></li>
    <?php endif ?>
    <?php if ($authors !== null): ?>
    <li class="contentSlide">
        <?php $lang->authors ?>:<br>
        <div>
        <?php foreach ($authors as $command): ?>
        &nbsp;&nbsp;- <?php echo $command ?><br>
        <?php endforeach ?>
        </div>
    </li>
    <?php endif ?>
    <?php if ($commands !== null): ?>
    <li class="contentSlide">
        <?php $lang->commands ?>:<br>
        <div>
        <?php foreach ($commands as $command => $infos): ?>
        &nbsp;&nbsp;- <?php echo $command ?><br>
        <?php endforeach ?>
        </div>
    </li>
    <?php endif ?>
    <?php if ($depend !== null): ?>
    <li class="contentSlide">
        <?php $lang->dependencies ?>:<br>
        <div>
        <?php foreach ($depend as $dependency): ?>
        &nbsp;&nbsp;- <?php echo $dependency ?><br>
        <?php endforeach ?>
        </div>
    </li>
    <?php endif ?>
    <li><?php $lang->datafolder ?>: <span class="value" id="plugin_datafolder"><?php echo $dataFolder ?></span></li>
</ul>
<script type="text/javascript">
    $('#plugin .contentSlide').click(function(e){
        $(e.target).children('div').toggle('fast');
    });
</script>