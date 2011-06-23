<?php $lang = Lang::instance('player') ?>
<?php $genericLang = Lang::instance('generic') ?>
<script type="text/javascript">
    var player = '<?php echo $player ?>';
</script>
<ul class="rounded">
    <li><?php $lang->name ?>: <span id="player_name"><?php $genericLang->progress ?></span><span id="player_head" style="background-image:url('backend/playerhead.php?player=<?php echo $player ?>')"></span></li>
    <li><?php $lang->displayname ?>: <span id="player_displayname"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->lifes ?>:
        <div id="player_health">
            <span class="heart"><span></span></span>
            <span class="heart"><span></span></span>
            <span class="heart"><span></span></span>
            <span class="heart"><span></span></span>
            <span class="heart"><span></span></span>
            <span class="heart"><span></span></span>
            <span class="heart"><span></span></span>
            <span class="heart"><span></span></span>
            <span class="heart"><span></span></span>
            <span class="heart"><span></span></span>
        </div>
    <li class="arrow"><a href="" id="player_world"><?php $lang->world ?>: <span><?php $genericLang->progress ?></span></a></li>
    <li>
        <?php $lang->position ?>:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;X: <span id="player_pos0"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Y: <span id="player_pos1"><?php $genericLang->progress ?></span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;Z: <span id="player_pos2"><?php $genericLang->progress ?></span>
    </li>
    <li><?php $lang->orientation ?>: <span id="player_pos3"><?php $genericLang->progress ?></span></li>
    <li><?php $lang->ip ?>: <span id="player_ip"><?php $genericLang->progress ?></span></li>
</ul>
<ul class="rounded">
    <li class="arrow"><a href="#" class="toggleoverlay"><?php $lang->utils ?></a></li>
</ul>
<?php $this->displayTemplateFile('generic/playerutils') ?>
<script type="text/javascript">
    var succeeded = false;
    var request = new ApiRequest('player', 'info');
    request.data({player: player, format:'json'});
    request.ignoreFirstFail(true);
    request.onSuccess(refreshData);
    request.onFailure(function(error){
        switch(error)
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
                    alert('<?php $lang->playerleft_alert ?>');
                }
                else
                {
                    redirectTo('players.html?msg=' + urlencode('<?php $lang->playerleft_msg ?>'));
                }
        }
    });
    
    function refreshData(data)
    {
        succeeded = true;
        data = eval('(' + data + ')');
        document.getElementById('player_name').innerHTML = data.name;
        document.getElementById('player_displayname').innerHTML = parseColors(data.displayName);
        var hearts = Math.floor(data.health / 2);
        $('#player_health').attr('title', data.health);
        $('#player_health span.heart span').removeClass('full');
        $('#player_health span.heart span').removeClass('half');
        $('#player_health span.heart:lt(' + hearts + ') span').addClass('full');
        if (data.health % 2 == 1)
        {
            $('#player_health span.heart:eq(' + hearts + ') span').addClass('half');
        }
        var world = document.getElementById('player_world');
        world.setAttribute('href', 'world.html?world=' + data.world);
        world.getElementsByTagName('span')[0].innerHTML = data.world;
        for (var index in data.position)
        {
            var elem = document.getElementById('player_pos' + index);
            elem.innerHTML = (Math.round(data.position[index] * 1000) / 1000);
            elem.setAttribute('title', data.position[index]);
        }
        document.getElementById('player_ip').innerHTML = data.ip;
    }

    $('#player_health span.heart').bind('touchstart', function(e){
        $(e.target).parent().trigger('touchstart', e);
        e.preventDefault();
        e.stopImmediatePropagation();
    });
    
    var intervalID = null;
    function init()
    {
        $('#player_info').parent('li').remove();
        prepareOverlay('#player_overlay');
        request.execute();
        intervalID = setInterval(request.execute, 10000);
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
    