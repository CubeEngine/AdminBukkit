<?php $lang = Lang::instance('players') ?>
<h2><?php if (!empty($world)): ?>
<?php $lang->playersworld($world) ?>:
<?php else: ?>
<?php $lang->allplayers ?>:
<?php endif ?>
    [ <span id="players_online">0</span> / <span id="players_limit">0</span> ]
</h2>
<ul data-role="listview" id="players_list">
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

    function refreshData(data)
    {
        list.html('');
        if (data == '')
        {
            $('#players_online').html(0);
            var li = document.createElement('li');
            li.innerHTML = '<?php $lang->noplayers ?>';
            list.appendChild(li);
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
                mainLink.attr('href', '<?php $this->page('player') ?>/?player=' + players[i]);
                var icon = $('<img>');
                icon.addClass('ui-li-icon');
                icon.attr('src', BASE_PATH + 'backend/playerhead.php?size=16&player=' + players[i])
                mainLink.append(icon);
                li.append(mainLink);
                var minorLink = $('<a>');
                minorLink.attr('href', '<?php $this->page('playerpopup') ?>');
                li.append(minorLink)
                list.append(li);
            }
            list.listview('refresh')
        }
    }
    
    $('div.toolbar a.button').click(function(){
        request.execute();
        return false;
    });

    var intervalId = null;
    
    $('#players').bind('pageshow', function(){
        var maxPlayersRequest = new ApiRequest('server', 'maxplayers');
        maxPlayersRequest.onSuccess(function(data){
            $('#players_limit').html(data);
        });
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

    
    /**** Overlay Handler ****/
    $('#player_ban').click(function(){
        if (ban_player(player, true))
        {
            refreshData();
            toggleOverlay('#player_overlay');
        }
        return false;
    });
    $('#player_kick').click(function(){
        if (player_kick(player, true))
        {
            refreshData();
            toggleOverlay('#player_overlay');
        }
        return false;
    });
    $('#player_tell').click(function(){
        player_tell(player);
        return false;
    });
    $('#player_kill').click(function(){
        player_kill(player);
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
    $('#player_clearinv').click(function(){
        player_clearinv(player);
        return false;
    });
    $('#player_give').click(function(){
        player_give(player);
        return false;
    });
    $('#player_teleport').click(function(){
        player_teleport(player);
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
    $('#player_info').click(function(){
        redirectTo('<?php $this->page('player') ?>?player=' + player);
        return false;
    });
</script>
