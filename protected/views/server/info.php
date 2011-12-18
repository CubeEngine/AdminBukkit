<ul data-role="listview" data-inset="true" id="server_info">
    <!-- Basic -->
    <li data-role="list-divider">
        <?php echo Yii::t('server', 'Basic information') ?>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Server name') ?>:</span>
        <span id="server_info_basic_name" title="" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Server IP') ?>:</span>
        <span id="server_info_basic_ip" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Server port') ?>:</span>
        <span id="server_info_basic_port" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Server uptime') ?>:</span><br>
        <span id="server_info_basic_uptime" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('server/console') ?>"><?php echo Yii::t('server', 'Console') ?></a>
    </li>
    <!-- Configuration -->
    <li data-role="list-divider">
        <?php echo Yii::t('server', 'Configuration') ?>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Mode') ?>:</span>
        <span class="value" id="server_info_config_mode"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Whitelist') ?>:</span>
        <span class="value" id="server_info_config_whitelist"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Flying') ?>:</span>
        <span class="value" id="server_info_config_flying"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Nether') ?>:</span>
        <span class="value" id="server_info_config_nether"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'The end') ?>:</span>
        <span class="value" id="server_info_config_end"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Gamemode') ?>:</span>
        <span class="value" id="server_info_config_defgamemode"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'View distance') ?>:</span>
        <span class="value">
            <span id="server_info_config_viewdistance"><?php echo Yii::t('generic', 'Loading...') ?></span>
            <?php echo Yii::t('server', 'chunk(s)') ?>
        </span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Spawn protection') ?>:</span>
        <span class="value">
            <span id="server_info_config_spawnradius"><?php echo Yii::t('generic', 'Loading...') ?></span>
            <?php echo Yii::t('server', 'block(s)') ?>
        </span>
    </li>
    <!-- Versions -->
    <li data-role="list-divider">
        <?php echo Yii::t('server', 'Versions') ?>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Bukkit') ?>:</span>
        <span id="server_info_versions_bukkit" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Implementation') ?>:</span>
        <span id="server_info_versions_implementation" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'ApiBukkit') ?>:</span>
        <span id="server_info_versions_apibukkit" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'BasicApi') ?>:</span>
        <span id="server_info_versions_basicapi" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <!-- Numbers -->
    <li data-role="list-divider">
        <?php echo Yii::t('server', 'Numbers') ?>
    </li>
    <li>
        <a href="#" id="server_info_numbers_ram"><?php echo Yii::t('server', 'Memory') ?>:
        <span class="value"><span id="server_info_numbers_ram_free"><?php echo Yii::t('generic', 'Loading...') ?></span> / <span id="server_info_numbers_ram_max"><?php echo Yii::t('generic', 'Loading...') ?></span> MB</span></a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('player/list') ?>"><?php echo Yii::t('player', 'Players') ?>:
        <span class="value"><span id="server_info_numbers_online"><?php echo Yii::t('generic', 'Loading...') ?></span> / <span id="server_info_numbers_maxplayers"><?php echo Yii::t('generic', 'Loading...') ?></span></span></a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('world/list') ?>"><?php echo Yii::t('world', 'Worlds') ?>:
        <span id="server_info_numbers_worlds" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span></a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('plugin/list') ?>"><?php echo Yii::t('plugin', 'Plugins') ?>:
        <span id="server_info_numbers_plugins" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span></a>
    </li>
    <!-- Utilities -->
    <li data-role="list-divider">
        <?php echo Yii::t('server', 'Utilities') ?>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('server/playerbans') ?>" data-rel="dialog"><?php echo Yii::t('server', 'Banned players') ?></a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('server/ipbans') ?>" data-rel="dialog"><?php echo Yii::t('server', 'Banned IPs') ?></a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('server/whitelist') ?>" data-rel="dialog"><?php echo Yii::t('server', 'Whitelist') ?></a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('server/operators') ?>" data-rel="dialog"><?php echo Yii::t('server', 'Operators') ?></a>
    </li>
    <li>
        <a href="#" id="server_info_utilities_broadcast"><?php echo Yii::t('server', 'Broadcast') ?></a>
    </li>
    <li>
        <a href="#" id="server_info_utilities_reload"><?php echo Yii::t('server', 'Reload') ?></a>
    </li>
    <li>
        <a href="#" id="server_info_utilities_stop"><?php echo Yii::t('server', 'Shutdown') ?></a>
    </li>
</ul>
<script type="text/javascript">
    var infoRequest = new ApiRequest('server', 'info');
    infoRequest.onSuccess(refreshData);
    infoRequest.data({format: 'json'});
    infoRequest.onBeforeSend(null);
    infoRequest.onComplete(null);
    infoRequest.ignoreFirstFail(true);

    function refreshData(data)
    {
        $('#server_info_basic_name').html(data.name);
        $('#server_info_basic_name').attr('title', 'ID: ' + data.id);
        if (data.ip)
        {
            $('#server_info_basic_ip').html(data.ip);
        }
        else
        {
            $('#server_info_basic_ip').html('<?php echo gethostbyname($server->getHost()) ?>');
        }
        $('#server_info_basic_port').html(data.port);

        $('#server_info_config_mode').html(AdminBukkit.t('server', data.onlinemode ? 'Online' : 'Offline'));
        $('#server_info_config_whitelist').html(AdminBukkit.t('server', data.awhitelisted ? 'Enabled' : 'Disabled'));
        $('#server_info_config_flying').html(AdminBukkit.t('generic', data.allowNether ? 'Allowed' : 'Disallowed'));
        $('#server_info_config_nether').html(AdminBukkit.t('generic', data.allowEnd ? 'Enabled' : 'Disabled'));
        $('#server_info_config_end').html(AdminBukkit.t('generic', data.allowFlight ? 'Enabled' : 'Disabled'));
        $('#server_info_config_defgamemode').html(AdminBukkit.t('generic', AdminBukkit.getGamemodeById(data.defaultGamemode).toLowerCase()));
        $('#server_info_config_viewdistance').html(data.viewDistance);
        $('#server_info_config_spawnradius').html(data.spawnRadius);

        $('#server_info_versions_bukkit').html(data.versions.bukkit);
        $('#server_info_versions_implementation').html(data.versions.server);
        $('#server_info_versions_apibukkit').html(data.versions.apibukkit);
        $('#server_info_versions_basicapi').html(data.versions.basicapi);
        
        $('#server_info_numbers_online').html(data.players);
        $('#server_info_numbers_maxplayers').html(data.maxplayers);
        $('#server_info_numbers_worlds').html(data.worlds);
        $('#server_info_numbers_plugins').html(data.plugins);
        
        var max = Math.round(data.maxmemory / 1024 / 1024);
        var free = Math.round(data.freememory / 1024 / 1024);
        $('#server_info_numbers_ram_max').html(max);
        $('#server_info_numbers_ram_free').html(max - free);

        var minutes = Math.floor(data.uptime / 60);
        var seconds = data.uptime % 60;
        var hours = Math.floor(minutes / 60);
        minutes = minutes % 60;
        var days = Math.floor(hours / 24);
        hours = hours % 24;
        var format = '<?php echo Yii::t('server', '{0} Day(s), {1} Hour(s), {2} Minute(s) and {3} Second(s)') ?>';
        $('#server_info_basic_uptime').html(format.replace('{0}', days).replace('{1}', hours).replace('{2}', minutes).replace('{3}', seconds));
    }

    var infoInterval = null;

    $('#server_info').bind('pageshow', function(){
        infoRequest.execute();
        infoInterval = setInterval(infoRequest.execute, 5000);
    }).bind('pagehide', function(){
        if (infoInterval)
        {
            clearInterval(infoInterval);
        }
    }).bind('pagecreate', function(){
        $('#toolbar_server_info_refresh').click(function(){
            infoRequest.execute();
        });

        $('#server_info_utilities_reload').click(function(){
            if (confirm('<?php echo Yii::t('server', 'Are you sure to reload the server?') ?>'))
            {
                var request = new ApiRequest('server', 'reload');
                request.onSuccess(function(){
                    alert('<?php echo Yii::t('server', 'Server successfully reloaded!\nInfos will be reloaded...') ?>');
                    infoRequest.execute();
                });
                request.execute();
            }
            return false;
        });

        $('#server_info_numbers_ram').click(function(e){
            e.preventDefault();
            if (confirm('<?php echo Yii::t('server', 'Do you really want to run the garbage collector?') ?>'))
            {
                var request = new ApiRequest('server', 'garbagecollect');
                request.onSuccess(function(){
                    alert('<?php echo Yii::t('server', 'Garbage collector was successfully executed!') ?>');
                });
                request.execute();
            }
        });

        $('#server_info_utilities_stop').click(function(){
            if (confirm('<?php echo Yii::t('server', 'Are you sure you want to stop the server?') ?>'))
            {
                if (confirm('<?php echo Yii::t('server', 'Are you really really sure??') ?>'))
                {
                    var request = new ApiRequest('server', 'stop');
                    request.onSuccess(function(){
                        alert('<?php echo Yii::t('server', 'The server was successfully stopped!') ?>');
                    });
                    request.execute();
                }
            }
        });

        $('#server_info_utilities_broadcast').click(function(){
            var message = prompt('<?php echo Yii::t('server', 'Please enter a message:') ?>', '');
            if (!message)
            {
                return false;
            }
            var request = new ApiRequest('server', 'broadcast')
            request.onSuccess(function(){
                alert('<?php echo Yii::t('server', 'Message was successfully sent!') ?>');
            });
            request.execute({message: message.substr(0, 100)});
            return false;
        });
    });
</script>