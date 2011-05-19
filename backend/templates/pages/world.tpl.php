<?php $lang = Lang::instance('world') ?>
<?php $genericLang = Lang::instance('generic') ?>
<ul class="rounded">
    <li><?php $lang->name ?>: <span id="world_name"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->type ?>: <span id="world_type"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->seed ?>: <span id="world_seed"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->pvp ?>: <span id="world_pvp_display"><?php $genericLang->progress ?></span></li>
    <li>
        <?php $lang->spawnpoint ?>:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;X: <span id="world_spawn0"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Y: <span id="world_spawn1"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Z: <span id="world_spawn2"><?php $genericLang->progress ?></span>
    </li>
    <li><?php $lang->time ?>: <span id="world_time_display"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->weatherduration ?>: <span id="world_weather"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->thunderduration ?>: <span id="world_thunder"><?php $genericLang->progress ?></span></li>
    <li class="arrow"><a href="players.html?world=<?php echo $world ?>"><?php $lang->players ?>: <span id="world_players"><?php $genericLang->progress ?></span></a></li>
</ul>
<ul class="rounded">
    <li><a href="#" class="toggleoverlay"><?php $lang->utils ?></a></li>
</ul>
<?php $this->displayTemplateFile('generic/worldutils') ?>
<script type="text/javascript">
    var world = '<?php echo $world ?>';
    
    var request = new ApiRequest('world', 'info');
    request.onSuccess(refreshData);
    request.onFailure(function(){
        alert('failed to load infos');
    });
    request.data({world: world, format: 'json'});
    
    function refreshData(data)
    {
        data = eval('(' + data + ')');
        document.getElementById('world_name').innerHTML = data.name;
        document.getElementById('world_type').innerHTML = data.environment.toLowerCase();
        document.getElementById('world_seed').innerHTML = data.seed;
        document.getElementById('world_pvp_display').innerHTML = (data.pvp ? '<?php $genericLang->Yes ?>' : '<?php $genericLang->No ?>');
        for (var i = 0; i < data.spawnLocation.length; i++)
        {
            document.getElementById('world_spawn' + i).innerHTML = data.spawnLocation[i];
        }
        var time = document.getElementById('world_time_display');
        time.innerHTML = data.time;
        time.setAttribute('title', data.fullTime);
        document.getElementById('world_weather').innerHTML = data.weatherDuration;
        document.getElementById('world_thunder').innerHTML = data.thunderDuration;
        document.getElementById('world_players').innerHTML = data.players;
    }
    
    function init()
    {
        $('#world_info').parent('li').remove();
        prepareOverlay('#world_overlay');
        request.execute();
    }
    
    $('.toolbar a.button').click(function(){
        request.execute();
        return false;
    });
    
    $('#world_time').click(function(){
        world_time(world);
        request.execute();
        return false;
    });
    $('#world_pvp').click(function(){
        world_pvp(world);
        request.execute();
        return false;
    });
    $('#world_storm').click(function(){
        world_storm(world);
        request.execute();
        return false;
    });
    $('#world_spawn').click(function(){
        world_spawn(world);
        request.execute();
        return false;
    });
    $('#world_playerlist').click(function(){
        redirectTo('players.html?world=' + world);
        return false;
    });
</script>