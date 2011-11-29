<ul id="ipbanlist_list" data-role="listview" data-filter="true">
    <li><?php echo Yii::t('generic', 'Loading the banned IPs...') ?></li>
</ul>
<script type="text/javascript" src="<?php echo $this->createUrl('javascript/translation', array('cat' => 'serverutils')) ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->basePath ?>/res/js/serverutils.js"></script>
<script type="text/javascript">
    var listRequest = new ApiRequest('ban', 'get');
    listRequest.data({format: 'json'});
    listRequest.onSuccess(refreshData);
    var list = $('#ipbanlist_list');

    function refreshData(data)
    {
        //data = eval('(' + data + ')');
        data = data.ip;
        list.html('');
        if (data.length == 0)
        {
            var li = $('<li>');
            li.text('<?php echo Yii::t('server', 'There are no banned IPs.') ?>');
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
        if (unban_ip(e.target.innerHTML, true))
        {
            listRequest.execute();
        }
    }

    $('#server_ipbans').bind('pagecreate', function(){
        $('#ipbanlist_toolbar_button').click(function(){
            if (ban_ip(null, true))
            {
                listRequest.execute();
            }
            return false;
        });
    }).bind('pageshow', function(){
        listRequest.execute();
    });
</script>