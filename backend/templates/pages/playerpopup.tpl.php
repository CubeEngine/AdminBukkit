<?php $lang = Lang::instance('playerutils') ?>
<ul data-role="listview">
    <li><a href="#" id="player_kick"><?php $lang->kick ?></a></li>
    <li><a href="#" id="player_ban"><?php $lang->ban ?></a></li>
    <li><a href="#" id="player_teleport"><?php $lang->teleport ?></a></li>
    <li><a href="#" id="player_tell"><?php $lang->tell ?></a></li>
    <li><a href="#" id="player_burn"><?php $lang->burn ?></a></li>
    <li><a href="#" id="player_heal"><?php $lang->heal ?></a></li>
    <li><a href="#" id="player_kill"><?php $lang->kill ?></a></li>
    <li><a href="#" id="player_clearinv"><?php $lang->clearinv ?></a></li>
    <li><a href="#" id="player_give"><?php $lang->give ?></a></li>
    <li><a href="#" id="player_op"><?php $lang->op ?></a></li>
    <li><a href="#" id="player_deop"><?php $lang->deop ?></a></li>
</ul>
<script type="text/javascript" src="<?php echo Router::instance()->getBasePath() ?>backend/javascriptlang.php?file=playerutils"></script>
<script type="text/javascript" src="<?php $this->res('js/playerutils.js') ?>"></script>
<script type="text/javascript" src="<?php echo Router::instance()->getBasePath() ?>backend/javascriptlang.php?file=serverutils"></script>
<script type="text/javascript" src="<?php $this->res('js/serverutils.js') ?>"></script>
<script type="text/javascript">

    var player = '<?php echo $player ?>';

    $('#playerpopup').bind('pagecreate', function(){
        $('#player_kick').click(function(){
            if (player_kick(player, true))
            {
                refreshData();
                toggleOverlay('#player_overlay');
            }
            return false;
        });
        $('#player_ban').click(function(){
            if (ban_player(player, true))
            {
                refreshData();
                toggleOverlay('#player_overlay');
            }
            return false;
        });
        $('#player_teleport').click(function(){
            player_teleport(player);
            return false;
        });
        $('#player_tell').click(function(){
            player_tell(player);
            return false;
        });
        $('#player_burn').click(function(){
            player_burn(player);
            return false;
        });
        $('#player_heal').click(function(){
            player_heal(player);
            return false;
        });
        $('#player_kill').click(function(){
            player_kill(player);
            return false;
        });
        $('#player_clearinv').click(function(){
            player_clearinv(player);
            return false;
        });
        $('#player_give').click(function(){
            player_give(player);
            return false;
        });
        $('#player_op').click(function(){
            player_op(player);
            return false;
        });
        $('#player_deop').click(function(){
            player_deop(player);
            return false;
        });
    });

</script>