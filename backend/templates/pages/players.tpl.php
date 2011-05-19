<?php $lang = Lang::instance('players') ?>
<?php if (!empty($world)): ?>
<h2><?php $lang->playersworld($world) ?>:
<?php else: ?>
<h2><?php $lang->allplayers ?>:
<?php endif ?>
    [ <span id="players_online">0</span> / <span id="players_limit">0</span> ]
</h2>
<ul class="rounded" id="players_list">
    <li><?php $lang->loadinglist ?></li>
</ul>
<?php if (!empty($world)): ?>
<ul class="rounded">
    <li class="arrow"><a href="players.html" id="players_all"><?php $lang->allplayers ?></a></li>
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
    
    var list = document.getElementById('players_list');
    var request = new ApiRequest(dataSource[0], dataSource[1]);
    request.method('GET');
    request.data({world: world});
    request.onSuccess(function(data){
        refreshData(data);
    });
    request.onFailure(function(){
        alert('Failed to load the list');
    });

    function refreshData(data)
    {
        list.innerHTML = '';
        if (data == '')
        {
            $('#players_online').html(0);
            var li = document.createElement('li');
            li.innerHTML = '<?php $lang->noplayers ?>';
            list.appendChild(li);
        }
        else
        {
            var players = data.split(',');
            $('#players_online').html(players.length);
            for (var i = 0; i < players.length; i++)
            {
                var li = document.createElement('li');
                li.setAttribute('class', 'arrow');
                var a = document.createElement('a');
                a.innerHTML = players[i];
                a.href = '#';
                $(a).click(overlayHandler);
                li.appendChild(a);
                list.appendChild(li);
            }
        }
    }
    
    function overlayHandler(e)
    {
        player = e.target.innerHTML;
        toggleOverlay('#player_overlay');
        e.preventDefault();
    }
    
    $('div.toolbar a.button').click(function(){
        request.execute();
        return false;
    });

    function init()
    {
        prepareOverlay('#player_overlay');
        apiCall("server", "maxplayers", function(data){
            $('#players_limit').html(data);
        });
        request.execute();
        setInterval(request.execute, 10000);
    }

    
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
    $('#player_info').click(function(){
        redirectTo('player.html?player=' + player);
        return false;
    });
</script>