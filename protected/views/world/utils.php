<ul data-role="listview">
    <li><a href="<?php echo $this->createUrl('player/list', array('world' => $world))?>"><?php echo Yii::t('world', 'Playerlist') ?></a></li>
    <li><a href="#" id="world_utils_time"><?php echo Yii::t('world', 'Set time') ?></a></li>
    <li><a href="#" id="world_utils_storm"><?php echo Yii::t('world', 'Enable/Disable the storm') ?></a></li>
    <li><a href="#" id="world_utils_pvp"><?php echo Yii::t('world', 'Activate/Deactivate PVP') ?></a></li>
    <li><a href="#" id="world_utils_spawn"><?php echo Yii::t('world', 'Move the spawn') ?></a></li>
</ul>
<script type="text/javascript" src="<?php echo $this->createUrl('javascript/translation', array('cat' => 'worldutils')) ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/res/js/worldutils.js"></script>
<script type="text/javascript">
    var world = '<?php echo $world ?>';

    $('#world_utils').bind('pagecreate', function(){
        $('#world_utils_time').click(function(){
            world_time(world);
            return false;
        });
        $('#world_utils_storm').click(function(){
            world_storm(world);
            return false;
        });
        $('#world_utils_pvp').click(function(){
            world_pvp(world);
            return false;
        });
        $('#world_utils_spawn').click(function(){
            world_spawn(world);
            return false;
        });
    });
</script>