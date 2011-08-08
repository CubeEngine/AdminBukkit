<?php $lang = Lang::instance('players') ?>
<h2><?php if (!empty($world)): ?>
<?php $lang->playersworld($world) ?>:
<?php else: ?>
<?php $lang->allplayers ?>:
<?php endif ?>
    [ <span id="players_online">0</span> / <span id="players_limit">0</span> ]
</h2>
<ul data-role="listview" id="players_list" data-split-icon="gear">
    <li><?php $lang->loadinglist ?></li>
</ul>
<?php if (!empty($world)): ?>
<ul data-role="listview">
    <li class="arrow"><a href="<?php $this->page('players') ?>" id="players_all"><?php $lang->allplayers ?></a></li>
</ul>
<?php endif ?>
<?php $this->displayTemplateFile('generic/playerutils') ?>
<script type="text/javascript">
    var world = '<?php echo $world ?>';
    var dataSource = ['player', 'list'];
    if (world != '')
    {
        dataSource = ['world', 'players'];
    }
    
    var list = $('#players_list');
    var request = new ApiRequest(dataSource[0], dataSource[1]);
    request.data({world: world});
    request.ignoreFirstFail(true);
    request.onSuccess(function(data){
        refreshData(data);
    });
    request.onFailure(function(){
        alert('Failed to load the list'); // @todo static language
    });
    var maxPlayersRequest = new ApiRequest('server', 'maxplayers');
    maxPlayersRequest.onSuccess(function(data){
        $('#players_limit').html(data);
    });
    maxPlayersRequest.onBeforeSend(null);
    maxPlayersRequest.onComplete(null);

    function refreshData(data)
    {
        list.html('');
        if (data == '')
        {
            $('#players_online').html('0');
            var li = $('<li>');
            li.html('<?php $lang->noplayers ?>');
            list.append(li);
        }
        else
        {
            var players = data.split(',').sort(realSort);
            $('#players_online').html(players.length);
            for (var i = 0; i < players.length; i++)
            {
                var li = $('<li>');
                var mainLink = $('<a>');
                mainLink.text(players[i]);
                mainLink.attr('href', '<?php $this->page('player') ?>?player=' + players[i]);
                //mainLink.data('rel', 'dialog');
                var icon = $('<img>');
                icon.addClass('ui-li-icon');
                icon.attr('src', BASE_PATH + 'backend/playerhead.php?size=16&player=' + players[i])
                mainLink.append(icon);
                li.append(mainLink);
                var minorLink = $('<a>');
                minorLink.attr('href', '<?php $this->page('playerpopup') ?>?player=' + players[i]);
                li.append(minorLink);
                list.append(li);
            }
        }
        list.listview('refresh');
    }
    
    $('div.toolbar a.button').click(function(){
        request.execute();
        return false;
    });

    var intervalId = null;
    
    $('#players').bind('pageshow', function(){
        maxPlayersRequest.execute();
        request.execute();
        intervalID = setInterval(request.execute, 10000);
    });

    $('#players').bind('pagehide', function(){
        if (intervalID)
        {
            clearInterval(intervalID);
        }
    });
</script>
