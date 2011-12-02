<h2><?php if (!empty($world)): ?>
<?php echo Yii::t('player', 'Players of the world "{world}"', array('{world}' => $world)) ?>:
<?php else: ?>
<?php echo YII::t('player', 'All players') ?>:
<?php endif ?>
    [ <span id="<?php echo $idPrefix ?>_playersonline">0</span> / <span id="<?php echo $idPrefix ?>_playerlimit">0</span> ]
</h2>
<ul data-filter="true" data-role="listview" id="<?php echo $idPrefix ?>_playerlist" data-split-icon="gear">
    <li><?php echo Yii::t('player', 'Playerlist is loading...') ?></li>
</ul>
<script type="text/javascript">
    var requestData = {
        format: 'json'
    };
    <?php if ($world): ?>
    var dataSource = ['world', 'players'];
    requestData.world = '<?php echo $world ?>';
    <?php else: ?>
    var dataSource = ['player', 'list'];
    <?php endif ?>

    var oldData = null;
    var $list = $('#<?php echo $idPrefix ?>_playerlist');
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
                alert('<?php echo Yii::t('player', 'No world was given!\n\nShowing all players now.') ?>');
                break;
            case 2:
                alert('<?php echo Yii::t('player', 'The given world was not found!\n\nShowing all players now.') ?>');
                break;
        }
    });
    var maxPlayersRequest = new ApiRequest('server', 'maxplayers');
    maxPlayersRequest.onSuccess(function(data){
        $('#<?php echo $idPrefix ?>_playerlimit').html(data);
    });
    maxPlayersRequest.onBeforeSend(null);
    maxPlayersRequest.onComplete(null);

    function refreshData(players)
    {
        //players = eval('(' + data + ')');
        if (!AdminBukkit.isDataDifferent(oldData, players))
        {
            return;
        }
        oldData = players;
        $list.html('');
        if (players.length == 0)
        {
            $('#<?php echo $idPrefix ?>_playersonline').text('0');
            $list.append($('<li><?php echo Yii::t('player', 'No players available') ?></li>'));
        }
        else
        {
            players = players.sort(AdminBukkit.realSort);
            $('#<?php echo $idPrefix ?>_playersonline').html(players.length);
            for (var i = 0; i < players.length; i++)
            {
                var li = $('<li>');
                var mainLink = $('<a>');
                mainLink.text(players[i]);
                mainLink.attr('href', '<?php echo $this->createUrl('player/show') ?>/' + players[i]);
                var icon = $('<img>');
                icon.addClass('ui-li-icon');
                icon.attr('src', '<?php echo $this->createUrl('player/head') ?>?size=16&player=' + players[i])
                mainLink.append(icon);
                li.append(mainLink);
                li.append($('<a href="<?php $this->createUrl('player/utils') ?>?player=' + players[i] + '" data-rel="dialog"></a>'));
                $list.append(li);
            }
            <?php if ($world): ?>
            var li = $('<li>');
            var link = $('<a>');
            link.attr('href', '<?php echo $this->createUrl('player/list') ?>');
            link.text('<?php echo YII::t('player', 'All players') ?>');
            li.append(link);
            $list.append(li);
            <?php endif ?>
        }
        $list.listview('refresh');
    }


    var playersIntervalId = null;    
    $('#<?php echo $idPrefix ?>_list').bind('pageshow', function(){
        maxPlayersRequest.execute();
        playersRequest.execute();
        playersIntervalId = setInterval(playersRequest.execute, 10000);
    }).bind('pagehide', function(){
        if (playersIntervalId)
        {
            clearInterval(playersIntervalId);
        }
    }).bind('pagecreate', function(){
        $('#toolbar_<?php echo $idPrefix ?>_playerlist_refresh').click(function(){
            playersRequest.execute();
            return false;
        });
    });
</script>
