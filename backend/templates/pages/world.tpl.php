<?php $lang = Lang::instance('world') ?>
<?php $genericLang = Lang::instance('generic') ?>
<div>
    <div>
        <?php $lang->name ?>: <span id="world_name"><?php $genericLang->progress ?></span>
    </div>
    <div>
        <?php $lang->type ?>: <span id="world_type"><?php $genericLang->progress ?></span>
    </div>
    <div>
        <?php $lang->seed ?>: <span id="world_seed"><?php $genericLang->progress ?></span>
    </div>
    <div>
        <?php $lang->pvp ?>: <span id="world_pvp_display"><?php $genericLang->progress ?></span>
    </div>
    <div>
        <?php $lang->spawnpoint ?>:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;X: <span id="world_spawn0"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Y: <span id="world_spawn1"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Z: <span id="world_spawn2"><?php $genericLang->progress ?></span>
    </div>
    <div>
        <?php $lang->time ?>: <span id="world_time_display"><?php $genericLang->progress ?></span>
    </div>
    <div>
        <?php $lang->weatherduration ?>: <span id="world_weather"><?php $genericLang->progress ?></span> <?php $lang->seconds ?>
    </div>
    <div>
        <?php $lang->thunderduration ?>: <span id="world_thunder"><?php $genericLang->progress ?></span> <?php $lang->seconds ?>
    </div>
    <div data-role="controlgroup">
        <a data-role="button" href="<?php $this->page('playersofworld') ?>?world=<?php echo $world ?>"><?php $lang->players ?>: <span id="world_players"><?php $genericLang->progress ?></span></a>
        <a data-role="button" href="#" id="toggleutils"><?php $lang->utils ?></a>
    </div>
</div>
<script type="text/javascript">
    var world = '<?php echo $world ?>';
    
    var succeeded = false;
    var request = new ApiRequest('world', 'info');
    request.onSuccess(refreshData);
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
            case 2:
                if (succeeded)
                {
                    clearInterval(intervalID);
                    $('.toggleoverlay, .toolbar a.button').unbind('click').click(function(){
                        alert('<?php $lang->disabled ?>');
                        return false;
                    });
                    alert('<?php $lang->worldremoved_alert ?>');
                }
                else
                {
                    redirectTo('<?php $this->page('worlds') ?>?msg=' + urlencode('<?php $lang->worldremoved_msg ?>'));
                }
        }
    });
    request.data({
        world: world,
        format: 'json'
    });
    
    function refreshData(data)
    {
        succeeded = true;
        data = eval('(' + data + ')');
        $('#world_name').text(data.name);
        $('#world_type').text(data.environment.toLowerCase());
        $('#world_seed').text(data.seed);
        $('#world_pvp_display').text(data.pvp ? '<?php $genericLang->Yes ?>' : '<?php $genericLang->No ?>');
        for (var i = 0; i < data.spawnLocation.length; i++)
        {
            $('#world_spawn' + i).text(data.spawnLocation[i]);
        }
        var time = $('#world_time_display');
        time.text(data.time);
        time.attr('title', data.fullTime);
        $('#world_weather').text(Math.round(data.weatherDuration / 20));
        $('#world_thunder').text(Math.round(data.thunderDuration / 20));
        $('#world_players').text(data.players);
    }
    
    $('#world').bind('pageshow', function(){
        request.execute();
    });
    
    $('.toolbar a.button').click(function(){
        request.execute();
        return false;
    });
</script>