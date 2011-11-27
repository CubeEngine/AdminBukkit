<h2><?php echo Yii::t('server', 'Serverinfo') ?>:</h2>
<ul data-role="listview" data-inset="true" id="server_info">
    <li>
        <span class="label"><?php echo Yii::t('server', 'Server name') ?>:</span>
        <span id="server_name" title="" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Server IP') ?>:</span>
        <span id="server_ip" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Server port') ?>:</span>
        <span id="server_port" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <span class="label"><?php echo Yii::t('server', 'Server uptime') ?>:</span><br>
        <span id="server_uptime" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('player/list') ?>"><?php echo Yii::t('player', 'Players') ?>: <span class="value"><span id="server_online"><?php echo Yii::t('generic', 'Loading...') ?></span> / <span id="server_maxplayers"><?php echo Yii::t('generic', 'Loading...') ?></span></span></a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('world/list') ?>"><?php echo Yii::t('world', 'Worlds') ?>: <span id="server_worlds" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span></a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('plugin/list') ?>"><?php echo Yii::t('plugin', 'Plugins') ?>: <span id="server_plugins" class="value"><?php echo Yii::t('generic', 'Loading...') ?></span></a>
    </li>
</ul>

<h2><?php echo Yii::t('server', 'Utilities') ?></h2>
<div data-role="controlgroup">
    <a data-role="button" href="#" id="server_stats_ram"><?php echo Yii::t('server', 'Memory') ?>: <span id="server_stats_ram_free"><?php echo Yii::t('generic', 'Loading...') ?></span> / <span id="server_stats_ram_max"><?php echo Yii::t('generic', 'Loading...') ?></span> MB</a>
    <a data-role="button" href="<?php echo $this->createUrl('server/playerbans') ?>" data-rel="dialog"><?php echo Yii::t('server', 'Banned players') ?></a>
    <a data-role="button" href="<?php echo $this->createUrl('server/ipbans') ?>" data-rel="dialog"><?php echo Yii::t('server', 'Banned IPs') ?></a>
    <a data-role="button" href="<?php echo $this->createUrl('server/whitelist') ?>" data-rel="dialog"><?php echo Yii::t('server', 'Whitelist') ?></a>
    <a data-role="button" href="<?php echo $this->createUrl('server/operators') ?>" data-rel="dialog"><?php echo Yii::t('server', 'Operators') ?></a>
    <a data-role="button" href="#" id="server_broadcast"><?php echo Yii::t('server', 'Broadcast') ?></a>
    <a data-role="button" href="<?php echo $this->createUrl('server/console') ?>"><?php echo Yii::t('server', 'Console view') ?></a>
    <a data-role="button" href="#" id="server_reload"><?php echo Yii::t('server', 'Reload') ?></a>
    <a data-role="button" href="#" id="server_stop"><?php echo Yii::t('server', 'Shutdown') ?></a>
</div>
<script type="text/javascript">

    var infoRequest = new ApiRequest('server', 'info');
    infoRequest.onSuccess(refreshData);
    infoRequest.data({format: 'json'});

    var statsRequest = new ApiRequest('server', 'stats');
    statsRequest.onSuccess(refreshMemStats);
    statsRequest.onBeforeSend(null);
    statsRequest.onComplete(null);
    statsRequest.data({format: 'json'});
    statsRequest.ignoreFirstFail(true);

    function refreshData(data)
    {
        data = eval('(' + data + ')');
        $('#server_name').html(data.name);
        $('#server_name').attr('title', 'ID: ' + data.id);
        if (data.ip)
        {
            $('#server_ip').html(data.ip);
        }
        else
        {
            $('#server_ip').html('<?php echo gethostbyname($server->getHost()) ?>');
        }
        $('#server_port').html(data.port);
        $('#server_online').html(data.players);
        $('#server_maxplayers').html(data.maxplayers);
        $('#server_worlds').html(data.worlds);
        $('#server_plugins').html(data.plugins);

        var minutes = Math.floor(data.uptime / 60);
        var seconds = data.uptime % 60;
        var hours = Math.floor(minutes / 60);
        minutes = minutes % 60;
        var days = Math.floor(hours / 24);
        hours = hours % 24;
        var format = '<?php echo Yii::t('server', '{0} Day(s), {1} Hour(s), {2} Minute(s) and {3} Second(s)') ?>';
        $('#server_uptime').html(format.replace('{0}', days).replace('{1}', hours).replace('{2}', minutes).replace('{3}', seconds));
    }

    function refreshMemStats(data)
    {
        data = eval('(' + data + ')');
        var max = Math.round(data.maxmemory / 1024 / 1024);
        var free = Math.round(data.freememory / 1024 / 1024);
        $('#server_stats_ram_max').html(max);
        $('#server_stats_ram_free').html(max - free);
    }

    var statsInterval = null;

    $('#server').bind('pageshow', function(){
        infoRequest.execute();
        statsRequest.execute();
        statsInterval = setInterval(statsRequest.execute, 5000);
    }).bind('pagehide', function(){
        if (statsInterval)
        {
            clearInterval(statsInterval);
        }
    }).bind('pagecreate', function(){
        $('#server_toolbar_button').click(function(){
            infoRequest.execute();
        });
        $('#server_reload').click(function(){
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

        $('#server_stats_ram').click(function(e){
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

        $('#server_stop').click(function(){
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

        $('#server_broadcast').click(function(){
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