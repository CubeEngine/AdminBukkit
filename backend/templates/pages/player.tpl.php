<?php $lang = Lang::instance('player') ?>
<?php $genericLang = Lang::instance('generic') ?>
<script type="text/javascript">
    var player = '<?php echo $player ?>';
</script>

<div id="player_primary_info">
    <div id="player_head">
        <img alt="" src="<?php echo $basePath ?>backend/playerhead.php?size=80&amp;player=<?php echo $player ?>">
    </div>
    <div id="player_names">
        <div id="player_displayname">
            <a href="#"><?php $genericLang->progress ?></a>
        </div>
        <div id="player_name">
            <span><?php $genericLang->progress ?></span>
        </div>
        <div class="ui-grid-a" id="position_box">
            <div class="ui-block-a">
                <div>X: <span id="player_pos0"><?php $genericLang->progress ?></span></div>
                <div>Z: <span id="player_pos2"><?php $genericLang->progress ?></span></div>
            </div>
            <div class="ui-block-b">
                <div>Y: <span id="player_pos1"><?php $genericLang->progress ?></span></div>
                <div><?php $lang->direction ?>: <span id="player_orientation"><?php $genericLang->progress ?></span></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
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
<div data-role="controlgroup">
    <a href="" id="player_world" data-role="button"><?php $lang->world ?>: <span id="player_world_name"><?php $genericLang->progress ?></span></a>
    <a id="ban_ip" href="#" data-role="button"><?php $lang->ip ?>: <span id="player_ip"><?php $genericLang->progress ?></span></a>
    <a href="<?php $this->page('playerpopup') ?>?player=<?php echo $player ?>" data-role="button" data-rel="dialog" data-transition="pop"><?php $lang->utils ?></a>
</div>
<script type="text/javascript" src="<?php echo Router::instance()->getBasePath() ?>backend/javascriptlang.php?file=serverutils"></script>
<script type="text/javascript" src="<?php $this->res('js/serverutils.js') ?>"></script>
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
                    redirectTo('<?php $this->page('players') ?>?msg=' + urlencode('<?php $lang->playerleft_msg ?>'));
                }
        }
    });
    
    function refreshData(data)
    {
        succeeded = true;
        data = eval('(' + data + ')');
        $('#player_name span:first').text(data.name);
        $('#player_displayname a:first').html(parseColors(data.displayName));
        var hearts = Math.floor(data.health / 2);
        $('#player_health').attr('title', data.health);
        $('#player_health span.heart span').removeClass('full');
        $('#player_health span.heart span').removeClass('half');
        $('#player_health span.heart:lt(' + hearts + ') span').addClass('full');
        if (data.health % 2 == 1)
        {
            $('#player_health span.heart:eq(' + hearts + ') span').addClass('half');
        }
        var armorDelta = 10 - Math.floor(data.armor / 2);
        $('#player_armor').attr('title', data.armor);
        $('#player_armor span.chestplate span').removeClass('full');
        $('#player_armor span.chestplate span').removeClass('half');
        $('#player_armor span.chestplate:gt(' + (armorDelta - 1) + ') span').addClass('full');
        if (data.armor % 2 == 1)
        {
            $('#player_armor span.chestplate:eq(' + (armorDelta - 1) + ') span').addClass('half');
        }
        $('#player_world').attr('href', '<?php $this->page('world') ?>?world=' + data.world);
        $('#player_world_name').text(data.world);
        for (var index in data.blockPosition)
        {
            var elem = $('#player_pos' + index);
            elem.text(data.blockPosition[index]);
            elem.attr('title', data.position[index]);
        }

        $('#player_orientation').text(data.orientation.cardinalDirection);
        $('#player_ip').text(data.ip);
    }

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
    }).bind('pagecreate', function(){
        $('#player_toolbar_button').bind('vmousedown', function(){
            request.execute();
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

        $('#player_health span.heart, #player_armor span.chestplate').bind('touchstart', function(e){
            $(e.target).parent().trigger('touchstart', e);
            e.preventDefault();
            e.stopImmediatePropagation();
        });

        $('#ban_ip').bind('vmousedown', function(){
            if (ban_ip($('#player_ip').text(), true))
            {
                if (player_kick(player, true))
                {
                    history.back();
                }
            }
            return false;
        });
    });
    
</script>
    