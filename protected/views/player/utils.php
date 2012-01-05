<ul data-role="listview">
    <li><a href="#" id="player_utils_kick"><?php echo Yii::t('playerutils', 'Kick') ?></a></li>
    <li><a href="#" id="player_utils_ban"><?php echo Yii::t('playerutils', 'Ban') ?></a></li>
    <li><a href="#" id="player_utils_teleport"><?php echo Yii::t('playerutils', 'Teleport') ?></a></li>
    <li><a href="#" id="player_utils_tell"><?php echo Yii::t('playerutils', 'Send a message') ?></a></li>
    <li><a href="#" id="player_utils_burn"><?php echo Yii::t('playerutils', 'Burn') ?></a></li>
    <li><a href="#" id="player_utils_heal"><?php echo Yii::t('playerutils', 'Heal') ?></a></li>
    <li><a href="#" id="player_utils_kill"><?php echo Yii::t('playerutils', 'Kill') ?></a></li>
    <li><a href="#" id="player_utils_clearinv"><?php echo Yii::t('playerutils', 'Clear inventory') ?></a></li>
    <li><a href="#" id="player_utils_give"><?php echo Yii::t('playerutils', 'Give') ?></a></li>
    <li><a href="#" id="player_utils_op"><?php echo Yii::t('playerutils', 'Op') ?></a></li>
    <li><a href="#" id="player_utils_deop"><?php echo Yii::t('playerutils', 'Deop') ?></a></li>
</ul>
<script type="text/javascript" src="<?php echo $this->createUrl('javascript/items') ?>"></script>
<script type="text/javascript" src="<?php echo $this->createUrl('javascript/translation', array('cat' => 'playerutils')) ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/res/js/playerutils.js"></script>
<script type="text/javascript" src="<?php echo $this->createUrl('javascript/translation', array('cat' => 'serverutils')) ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/res/js/serverutils.js"></script>
<script type="text/javascript">

    (function(){
        var player = '<?php echo $player ?>';

        $('#player_utils').bind('pagecreate', function(){
            $('#player_utils_kick').click(function(){
                if (player_kick(player, true))
                {
                    refreshData();
                    toggleOverlay('#player_utils_overlay');
                }
                return false;
            });
            $('#player_utils_ban').click(function(){
                if (ban_player(player, true))
                {
                    refreshData();
                    toggleOverlay('#player_utils_overlay');
                }
                return false;
            });
            $('#player_utils_teleport').click(function(){
                player_teleport(player);
                return false;
            });
            $('#player_utils_tell').click(function(){
                player_tell(player);
                return false;
            });
            $('#player_utils_burn').click(function(){
                player_burn(player);
                return false;
            });
            $('#player_utils_heal').click(function(){
                player_heal(player);
                return false;
            });
            $('#player_utils_kill').click(function(){
                player_kill(player);
                return false;
            });
            $('#player_utils_clearinv').click(function(){
                player_clearinv(player);
                return false;
            });
            $('#player_utils_give').click(function(){
                player_give(player);
                return false;
            });
            $('#player_utils_op').click(function(){
                player_op(player);
                return false;
            });
            $('#player_utils_deop').click(function(){
                player_deop(player);
                return false;
            });
        });
    })();

</script>