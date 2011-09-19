<?php $lang = Lang::instance('players') ?>
<h2><?php if (!empty($world)): ?>
<?php $lang->playersworld($world) ?>:
<?php else: ?>
<?php $lang->allplayers ?>:
<?php endif ?>
    [ <span id="players_online">0</span> / <span id="players_limit">0</span> ]
</h2>
<ul data-filter="true" data-role="listview" id="<?php echo $pageName ?>_players" data-split-icon="gear">
    <li><?php $lang->loadinglist ?></li>
</ul>
<script type="text/javascript">
    var requestData = {};
    <?php if (isset($world)): ?>
    var dataSource = ['world', 'players'];
    requestData.world = '<?php echo $world ?>';
    <?php else: ?>
    var dataSource = ['player', 'list'];
    <?php endif ?>
    
    var list = $('#<?php echo $pageName ?>_players');
    var playersRequest = new ApiRequest(dataSource[0], dataSource[1]);
    playersRequest.data(requestData);
    playersRequest.ignoreFirstFail(true);
    playersRequest.onSuccess(function(data){
        refreshData(data);
    });
    playersRequest.onFailure(function(err){
        switch(err)
        {
            case 1:
                alert('<?php $lang->noworld ?>');
                break;
            case 2:
                alert('<?php $lang->unknownworld ?>');
                break;
        }
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
            li.text('<?php $lang->noplayers ?>');
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
                var icon = $('<img>');
                icon.addClass('ui-li-icon');
                icon.attr('src', BASE_PATH + 'backend/playerhead.php?size=16&player=' + players[i])
                mainLink.append(icon);
                li.append(mainLink);
                li.append($('<a href="<?php $this->page('playerpopup') ?>?player=' + players[i] + '" data-rel="dialog" data-transition="pop"></a>'));
                list.append(li);
            }
            <?php if (isset($world)): ?>
            var li = $('<li>');
            var link = $('<a>');
            link.attr('href', '<?php $this->page('players') ?>');
            link.text('<?php $lang->allplayers ?>');
            li.append(link);
            list.append(li);
            <?php endif ?>
        }
        list.listview('refresh');
    }


    var playersIntervalId = null;    
    $('#<?php echo $pageName ?>').bind('pageshow', function(){
        maxPlayersRequest.execute();
        playersRequest.execute();
        playersIntervalId = setInterval(playersRequest.execute, 10000);
    }).bind('pagehide', function(){
        if (playersIntervalId)
        {
            clearInterval(playersIntervalId);
        }
    }).bind('pagecreate', function(){
        $('#<?php echo $pageName ?>_toolbar_button').bind('vmousedown', function(){
            playersRequest.execute();
            return false;
        });
    });
</script>
