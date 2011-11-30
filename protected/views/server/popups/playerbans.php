<ul id="playerbanlist_list" data-role="listview" data-filter="true">
    <li><?php echo Yii::t('server', 'Loading the banned players...') ?></li>
</ul>
<script type="text/javascript" src="<?php echo $this->createUrl('javascript/translation', array('cat' => 'serverutils')) ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/res/js/serverutils.js"></script>
<script type="text/javascript">
    var listRequest = new ApiRequest('ban', 'get');
    listRequest.data({format: 'json'});
    listRequest.onSuccess(refreshData);
    var list = $('#playerbanlist_list');

    function refreshData(data)
    {
        //data = eval('(' + data + ')');
        data = data.player;
        list.html('');
        if (data.length == 0)
        {
            var li = $('<li>');
            li.text('<?php echo Yii::t('server', 'No players are banned.') ?>');
            list.append(li);
        }
        else
        {
            for (var i = 0; i < data.length; i++)
            {
                var li = $('<li>');
                var mainLink = $('<a>');
                mainLink.text(data[i]);
                mainLink.attr('href', '#');
                mainLink.click(unban);
                li.append(mainLink);
                list.append(li);
            }
        }
        list.listview('refresh');
    }

    function unban(e)
    {
        e.preventDefault();
        if (unban_player(e.target.innerHTML, true))
        {
            listRequest.execute();
        }
    }

    $('#server_playerbans').bind('pagecreate', function(){
        $('#toolbar_server_banplayer').click(function(){
            if (ban_player(null, true))
            {
                listRequest.execute();
            }
            return false;
        });
    }).bind('pageshow', function(){
        listRequest.execute();
    });
</script>