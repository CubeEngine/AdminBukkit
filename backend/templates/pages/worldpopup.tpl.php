<?php $lang = Lang::instance('worldutils') ?>
<ul data-role="listview">
    <li><a href="<?php $this->page('players')?>?world=<?php echo $world ?>"><?php $lang->playerlist ?></a></li>
    <li><a href="#" id="worldpopup_time"><?php $lang->time ?></a></li>
    <li><a href="#" id="worldpopup_storm"><?php $lang->storm ?></a></li>
    <li><a href="#" id="worldpopup_pvp"><?php $lang->pvp ?></a></li>
    <li><a href="#" id="worldpopup_spawn"><?php $lang->spawn ?></a></li>
</ul>
<script type="text/javascript" src="<?php echo Router::instance()->getBasePath() ?>backend/javascriptlang.php?file=worldutils"></script>
<script type="text/javascript" src="<?php $this->res('js/worldutils.js') ?>"></script>
<script type="text/javascript">
    var world = '<?php echo $world ?>';

    $('#worldpopup').bind('pagecreate', function(){
        $('#worldpopup_time').bind('vmousedown', function(){
            world_time(world);
            return false;
        });
        $('#worldpopup_storm').bind('vmousedown', function(){
            world_storm(world);
            return false;
        });
        $('#worldpopup_pvp').bind('vmousedown', function(){
            world_pvp(world);
            return false;
        });
        $('#worldpopup_spawn').bind('vmousedown', function(){
            world_spawn(world);
            return false;
        });
    });
</script>