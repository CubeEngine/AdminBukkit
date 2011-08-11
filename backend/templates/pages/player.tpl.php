<?php $lang = Lang::instance('player') ?>
<?php $genericLang = Lang::instance('generic') ?>
<script type="text/javascript">
    var player = '<?php echo $player ?>';
</script>

<div class="ui-grid-a">
    <div class="ui-block-a">
        <img style="float:right" id="player_head" alt="" src="<?php echo $basePath ?>/backend/playerhead.php?size=80&amp;player=<?php echo $player ?>">
    </div>
    <div class="ui-block-b">
        <div>
            <a href="#" id="player_displayname"><?php $lang->displayname ?>: <span><?php $genericLang->progress ?></span></a>
        </div>
        <div>
            <?php $lang->name ?>: <span id="player_name"><?php $genericLang->progress ?></span>
        </div>
    </div>
</div>
<div class="ui-grid-a">
    <div class="ui-block-a">
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
    </div>
    <div class="ui-block-b">
        <div id="player_armor">
            <span class="chestplate"><span></span></span>
            <span class="chestplate"><span></span></span>
            <span class="chestplate"><span></span></span>
            <span class="chestplate"><span></span></span>
            <span class="chestplate"><span></span></span>
            <span class="chestplate"><span></span></span>
            <span class="chestplate"><span></span></span>
            <span class="chestplate"><span></span></span>
            <span class="chestplate"><span></span></span>
            <span class="chestplate"><span></span></span>
        </div>
    </div>
</div>

<a href="" id="player_world"><?php $lang->world ?>: <span><?php $genericLang->progress ?></span></a>

<?php $lang->position ?>:<br>
&nbsp;&nbsp;&nbsp;&nbsp;X: <span id="player_pos0"><?php $genericLang->progress ?></span><br>
&nbsp;&nbsp;&nbsp;&nbsp;Y: <span id="player_pos1"><?php $genericLang->progress ?></span><br>
&nbsp;&nbsp;&nbsp;&nbsp;Z: <span id="player_pos2"><?php $genericLang->progress ?></span>
<?php $lang->orientation ?>: <span id="player_pos3"><?php $genericLang->progress ?></span> | <span id="player_pos4"><?php $genericLang->progress ?></span>
<a id="ban_ip" href="#"><?php $lang->ip ?>: <span id="player_ip"><?php $genericLang->progress ?></span></a>

<div>
    <a href="<?php $this->page('playerpopup') ?>?player=<?php echo $player ?>" data-role="button" data-rel="dialog"><?php $lang->utils ?></a>
</div>
<script type="text/javascript" src="<?php echo Router::instance()->getBasePath() ?>backend/javascriptlang.php?file=playerutils"></script>
<script type="text/javascript" src="<?php $this->res('js/playerutils.js') ?>"></script>
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
        document.getElementById('player_displayname').getElementsByTagName('span')[0].innerHTML = parseColors(data.displayName);
        var hearts = Math.floor(data.health / 2);
        $('#player_health').attr('title', data.health);
        $('#player_health span.heart span').removeClass('full');
        $('#player_health span.heart span').removeClass('half');
        $('#player_health span.heart:lt(' + hearts + ') span').addClass('full');
        if (data.health % 2 == 1)
        {
            $('#player_health span.heart:eq(' + hearts + ') span').addClass('half');
        }

        var armor = Math.floor(data.armor / 2);
        $('#player_armor').attr('title', data.armor);
        $('#player_armor span.chestplate span').removeClass('full');
        $('#player_armor span.chestplate span').removeClass('half');
        $('#player_armor span.chestplate:lt(' + armor + ') span').addClass('full');
        if (data.armor % 2 == 1)
        {
            $('#player_armor span.chestplate:eq(' + armor + ') span').addClass('half');
        }
        var world = document.getElementById('player_world');
        world.setAttribute('href', '<?php $this->page('world') ?>?world=' + data.world);
        world.getElementsByTagName('span')[0].innerHTML = data.world;
        for (var index in data.position)
        {
            var elem = document.getElementById('player_pos' + index);
            elem.innerHTML = (Math.round(data.position[index] * 1000) / 1000);
            elem.setAttribute('title', data.position[index]);
        }
        document.getElementById('player_ip').innerHTML = data.ip;
    }

    $('#player_health span.heart, #player_armor span.chestplate').bind('touchstart', function(e){
        $(e.target).parent().trigger('touchstart', e);
        e.preventDefault();
        e.stopImmediatePropagation();
    });

    $('.toolbar a.button').click(function(){
        request.execute();
        return false;
    });

    $('#ban_ip').click(function(){
        if (ban_ip($('#player_ip').text(), true))
        {
            if (player_kick(player, true))
            {
                history.back();
            }
        }
        return false;
    });

    $('#player_displayname').click(function(){
        var displayname = prompt('<?php $lang->displayname_enter ?>', '');
        if (!displayname)
        {
            return false;
        }
        var displayNameRequest = new ApiRequest('player', 'displayname');
        displayNameRequest.onSuccess(function(){
            alert('<?php $lang->displayname_success ?>');
            request.execute();
        });
        displayNameRequest.onFailure(function(error){
            switch (error)
            {
                case 1:
                    alert('<?php $lang->displayname_noplayer ?>');
                    break;
                case 2:
                    alert('<?php $lang->displayname_playernotfound ?>');
                    break;
                case 3:
                    alert('<?php $lang->displayname_nodisplayname ?>');
                    break;
            }
        });
        displayNameRequest.execute({
            player: player,
            displayname: displayname
        });
    });

    var playerIntervalID = null;
    $('#player').bind('pageshow', function(){
        request.execute();
        playerIntervalID = setInterval(request.execute, 10000);
    })
    .bind('pagehide', function(){
        if (playerIntervalID)
        {
            clearInterval(playerIntervalID);
        }
    });
    
</script>
    