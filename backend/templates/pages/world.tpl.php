<?php $lang = Lang::instance('world') ?>
<?php $genericLang = Lang::instance('generic') ?>
<h2><?php $lang->world($world) ?></h2>
<ul data-role="listview" data-inset="true">
    <li>
        <?php $lang->name ?> <span class="value" id="world_name"><?php $genericLang->progress ?></span>
    </li>
    <li>
        <?php $lang->type ?> <span class="value" id="world_type"><?php $genericLang->progress ?></span>
    </li>
    <li>
        <?php $lang->seed ?> <span class="value" id="world_seed"><?php $genericLang->progress ?></span>
    </li>
    <li>
        <?php $lang->pvp ?> <span class="value" id="world_pvp_display"><?php $genericLang->progress ?></span>
    </li>
    <li>
        <?php $lang->spawnpoint ?><br>
        &nbsp;&nbsp;&nbsp;&nbsp;X: <span class="value" id="world_spawn0"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Y: <span class="value" id="world_spawn1"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Z: <span class="value" id="world_spawn2"><?php $genericLang->progress ?></span>
    </li>
    <li>
        <?php $lang->time ?> <span class="value" id="world_time_display"><?php $genericLang->progress ?></span>
    </li>
    <li>
        <?php $lang->weatherduration ?> <span class="value"><span id="world_weather"><?php $genericLang->progress ?></span> <?php $lang->seconds ?></span>
    </li>
    <li>
        <?php $lang->thunderduration ?> <span class="value"><span id="world_thunder"><?php $genericLang->progress ?></span> <?php $lang->seconds ?></span>
    </li>
    <li>
        <a href="<?php $this->page('playersofworld') ?>?world=<?php echo $world ?>"><?php $lang->players ?> <span class="value" id="world_players"><?php $genericLang->progress ?></span></a>
    </li>
</ul>
<div data-role="controlgroup">
    
    <a data-role="button" href="<?php $this->page('worldpopup') ?>?world=<?php echo $world ?>" data-rel="dialog" data-transition="pop"><?php $lang->utils ?></a>
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
    }).bind('pagecreate', function(){
        $('#world_toolbar_button').click(function(){
            request.execute();
            return false;
        });
    });
</script>