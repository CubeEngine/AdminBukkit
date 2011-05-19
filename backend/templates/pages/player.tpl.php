<?php $lang = Lang::instance('player') ?>
<?php $genericLang = Lang::instance('generic') ?>
<script type="text/javascript">
    var player = '<?php echo $player ?>';
</script>
<ul class="rounded">
    <li><?php $lang->name ?>: <span id="player_name"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->displayname ?>: <span id="player_displayname"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->lifes ?>: <span id="player_health"><?php $genericLang->progress ?></span> / 20</li>
    <li class="arrow"><a href="" id="player_world"><?php $lang->world ?>: <span><?php $genericLang->progress ?></span></a></li>
    <li>
        <?php $lang->position ?>:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;X: <span id="player_pos0"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Y: <span id="player_pos1"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Z: <span id="player_pos2"><?php $genericLang->progress ?></span>
    </li>
    <li><?php $lang->orientation ?>: <span id="player_pos3"><?php $genericLang->progress ?></span></li>
</ul>
<ul class="rounded">
    <li class="arrow"><a href="#" class="toggleoverlay"><?php $lang->utils ?></a></li>
</ul>
<?php $this->displayTemplateFile('generic/playerutils') ?>
<script type="text/javascript">
    var request = new ApiRequest('player', 'info');
    request.method('GET');
    request.data({player: player, format:'json'});
    request.onSuccess(function(data){
        refreshData(data);
    });
    request.onFailure(function(){
        alert('Failed to load infos');
    });
    
    function refreshData(raw)
    {
        var data = eval('(' + raw + ')');
        document.getElementById('player_name').innerHTML = data.name;
        document.getElementById('player_displayname').innerHTML = data.displayName;
        document.getElementById('player_health').innerHTML = data.health;
        var world = document.getElementById('player_world');
        world.setAttribute('href', 'world.html?world=' + data.world);
        world.getElementsByTagName('span')[0].innerHTML = data.world;
        for (var index in data.position)
        {
            var elem = document.getElementById('player_pos' + index);
            var parts = (data.position[index] + '').split('.');
            var shortened = '';
            if (parts.length > 1)
            {
                shortened = parts[0] + '.' + parts[1].substr(0, 3);
            }
            else
            {
                shortened = elem.innerHTML = parts[0];
            }
            elem.innerHTML = shortened;
            elem.setAttribute('title', data.position[index]);
        }
    }
    
    function init()
    {
        $('#player_info').parent('li').remove();
        prepareOverlay('#player_overlay');
        request.execute();
        setInterval(request.execute, 10000);
    }

    $('.toolbar a.button').click(function(){
        request.execute();
        return false;
    });
    /**** Overlay Handler ****/
    $('#player_ban').click(function(){
        if (ban_player(player, true))
        {
            history.back();
        }
        return false;
    });
    $('#player_kick').click(function(){
        if (player_kick(player, true))
        {
            history.back();
        }
        return false;
    });
    $('#player_tell').click(function(){
        player_tell(player);
        return false;
    });
    $('#player_kill').click(function(){
        player_kill(player);
        request.execute();
        return false;
    });
    $('#player_burn').click(function(){
        player_burn(player);
        request.execute();
        return false;
    });
    $('#player_heal').click(function(){
        player_heal(player);
        request.execute();
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
        request.execute();
        return false;
    });
    
</script>
    