<?php $lang = Lang::instance('server') ?>
<?php $genericLang = Lang::instance('generic') ?>
<h2><?php $lang->serverinfos ?>:</h2>
<ul class="rounded">
    <li><?php $lang->servername ?>: <span id="server_name" title=""><?php $genericLang->progress ?></span></li>
    <li><?php $lang->serverip ?>: <span id="server_ip"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->serverport ?>: <span id="server_port"><?php $genericLang->progress ?></span></li>
    <li class="arrow"><a href="<?php $this->page('players') ?>"><?php $lang->players ?>: <span id="server_online"><?php $genericLang->progress ?></span> / <span id="server_maxplayers"><?php $genericLang->progress ?></span></a></li>
    <li class="arrow"><a href="<?php $this->page('worlds') ?>"><?php $lang->worlds ?>: <span id="server_worlds"><?php $genericLang->progress ?></span></a></li>
    <li class="arrow"><a href="<?php $this->page('plugins') ?>"><?php $lang->plugins ?>: <span id="server_plugins"><?php $genericLang->progress ?></span></a></li>
    <li><?php $lang->uptime ?>: <span id="server_uptime"><?php $genericLang->progress ?></span></li>
</ul>
<h2><?php $lang->stats ?>:</h2>
<ul class="rounded">
    <li class="arrow"><a href="#" id="stats_ram"><?php $lang->ram ?>: <span id="stats_ram_free"><?php $genericLang->progress ?></span> / <span id="stats_ram_max"><?php $genericLang->progress ?></span> MB</a></li>
</ul>
<h2><?php $lang->utils ?></h2>
<div data-role="controlgroup">
    <a href="#" id="banplayer" data-role="button" data-rel="dialog"><?php $lang->banplayer ?></a>
    <a href="#" id="banip" data-role="button" data-rel="dialog"><?php $lang->banip ?></a>
    <a href="#" id="whitelist" data-role="button" data-rel="dialog"><?php $lang->addtowhitelist ?></a>
    <a href="#" id="operators" data-role="button" data-rel="dialog"><?php $lang->addoperator ?></a>
    <a href="#" id="broadcast" data-role="button"><?php $lang->broadcast ?></a>
    <a href="<?php $this->page('console') ?>" data-role="button"><?php $lang->consoleview ?></a>
    <a href="#" id="stop" data-role="button"><?php $lang->stop ?></a>
</div>
<div id="generic_overlay" class="overlay">
    <ul class="rounded">
        <li><a href="#" id="generic_add"></a></li>
    </ul>
    <h2 id="generic_headline"></h2>
    <div class="generic_scroller">
        <div>
            <ul id="generic_list" class="rounded">
                <li><?php $genericLang->progress ?></li>
            </ul>
        </div>
    </div>
    <ul>
        <li><a href="#" class="toggleoverlay"><?php $lang->close ?></a></li>
    </ul>
</div>
<script type="text/javascript">

    var infoRequest = new ApiRequest('server', 'info');
    infoRequest.onSuccess(refreshData);
    infoRequest.onFailure(function(){
        alert('failed to load infos'); // @todo hardcoded string
    });
    infoRequest.data({format: 'json'});
    
    var statsRequest = new ApiRequest('server', 'stats');
    statsRequest.onSuccess(refreshMemStats);
    statsRequest.onBeforeSend(null);
    statsRequest.onComplete(null);
    statsRequest.data({format: 'json'});
    statsRequest.ignoreFirstFail(true);
    statsRequest.onFailure(function(){
        alert('failed to load stats');
    });
    
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
            $('#server_ip').html('<?php echo gethostbyname($_SESSION['user']->getServerAddress()) ?>');
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
        var format = '<?php $lang->uptime_format ?>';
        $('#server_uptime').html(format.replace('{0}', days).replace('{1}', hours).replace('{2}', minutes).replace('{3}', seconds));
    }
    
    function refreshMemStats(data)
    {
        data = eval('(' + data + ')');
        var max = Math.round(data.maxmemory / 1024 / 1024);
        var free = Math.round(data.freememory / 1024 / 1024);
        $('#stats_ram_max').html(max);
        $('#stats_ram_free').html(max - free);
    }
    
    $('#stats_ram').click(function(e){
        e.preventDefault();
        if (confirm('<?php $lang->gc_confirm ?>'))
        {
            var request = new ApiRequest('server', 'garbagecollect');
            request.onSuccess(function(){
                alert('<?php $lang->gc_success ?>');
            });
            request.execute();
        }
    });
    $('.toolbar a.button').click(function(){
        if (confirm('<?php $lang->confirm_reload ?>'))
        {
            var request = new ApiRequest('server', 'reload');
            request.onSuccess(function(){
                alert('<?php $lang->reload_success ?>');
                infoRequest.execute();
            });
            request.execute();
        }
        return false;
    });
    $('#stop').click(function(){
        if (confirm('<?php $lang->stop_confirm ?>'))
        {
            if (confirm('<?php $lang->stop_confirm2 ?>'))
            {
                var request = new ApiRequest('server', 'stop');
                request.onSuccess(function(){
                    alert('<?php $lang->stop_success ?>');
                });
                request.execute();
            }
        }
    });
    $('#broadcast').click(function(){
        var message = prompt('<?php $lang->broadcast_prompt ?>', '');
        if (!message)
        {
            return false;
        }
        var request = new ApiRequest('server', 'broadcast')
        request.onSuccess(function(){
            alert('<?php $lang->broadcast_success ?>');
        });
        request.execute({message: message.substr(0, 100)});
        return false;
    });
    
    $('#server').bind('pageshow', function(){
        infoRequest.execute();
        statsRequest.execute();
        setInterval(statsRequest.execute, 5000);
    });
</script>