<ul data-role="listview" data-inset="true">
    <li>
        <?php echo Yii::t('world', 'Name:') ?> <span class="value" id="world_view_name"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <?php echo Yii::t('world', 'Type:') ?> <span class="value" id="world_view_type"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <?php echo Yii::t('world', 'Seed:') ?> <span class="value" id="world_view_seed"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <?php echo Yii::t('world', 'PVP:') ?> <span class="value" id="world_view_pvp_display"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <?php echo Yii::t('world', 'Spawn:') ?><br>
        &nbsp;&nbsp;&nbsp;&nbsp;X: <span class="value" id="world_view_spawn0"><?php echo Yii::t('generic', 'Loading...') ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Y: <span class="value" id="world_view_spawn1"><?php echo Yii::t('generic', 'Loading...') ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Z: <span class="value" id="world_view_spawn2"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <?php echo Yii::t('world', 'Time:') ?> <span class="value" id="world_view_time_display"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <?php echo Yii::t('world', 'Weather duration:') ?> <span class="value"><span id="world_view_weather"><?php echo Yii::t('generic', 'Loading...') ?></span> <?php echo Yii::t('world', 'second(s)') ?></span>
    </li>
    <li>
        <?php echo Yii::t('world', 'Thunder duration:') ?> <span class="value"><span id="world_view_thunder"><?php echo Yii::t('generic', 'Loading...') ?></span> <?php echo Yii::t('world', 'second(s)') ?></span>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('player/list', array('world' => $world)) ?>"><?php echo Yii::t('world', 'Players:') ?> <span class="value" id="world_view_players"><?php echo Yii::t('generic', 'Loading...') ?></span></a>
    </li>
</ul>
<div data-role="controlgroup">
    
    <a data-role="button" href="<?php echo $this->createUrl('world/utils', array('world' => $world)) ?>" data-rel="dialog"><?php echo Yii::t('world', 'Utilities') ?></a>
</div>
<script type="text/javascript">
    (function(){
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
                            alert('<?php echo Yii::t('world', 'Invalid function, the world no longer exists.\nReload the page to try again.') ?>');
                            return false;
                        });
                        alert('<?php echo Yii::t('world', 'The world was deleted.\nThe data can no longer be refreshed.') ?>');
                    }
                    else
                    {
                        AdminBukkit.redirectTo('<?php echo $this->createUrl('worlds') ?>', '<?php echo Yii::t('world', 'The world no longer exists.') ?>');
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
            $('#world_view_name').text(data.name);
            $('#world_view_type').text(AdminBukkit.getEnvById(data.environment).toLowerCase());
            $('#world_view_seed').text(data.seed);
            $('#world_view_pvp_display').text(data.pvp ? '<?php echo Yii::t('generic', 'Yes') ?>' : '<?php echo Yii::t('generic', 'No') ?>');
            for (var i = 0; i < data.spawnLocation.length; i++)
            {
                $('#world_view_spawn' + i).text(data.spawnLocation[i]);
            }
            var time = $('#world_view_time_display');
            time.text(data.time);
            time.attr('title', data.fullTime);
            $('#world_view_weather').text(Math.round(data.weatherDuration / 20));
            $('#world_view_thunder').text(Math.round(data.thunderDuration / 20));
            $('#world_view_players').text(data.players);
        }

        $('#world_view').bind('pageshow', function(){
            request.execute();
        }).bind('pagecreate', function(){
            $('#toolbar_world_view_refresh').click(function(){
                request.execute();
                return false;
            });
        });
    })();
</script>