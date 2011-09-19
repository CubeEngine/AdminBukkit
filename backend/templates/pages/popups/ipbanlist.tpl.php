<?php $lang = Lang::instance('ipbanlist') ?>
<ul id="ipbanlist_list" data-role="listview" data-filter="true">
    <li><?php $lang->loading ?></li>
</ul>
<script type="text/javascript" src="<?php echo Router::instance()->getBasePath() ?>backend/javascriptlang.php?file=serverutils"></script>
<script type="text/javascript" src="<?php $this->res('js/serverutils.js') ?>"></script>
<script type="text/javascript">
    var listRequest = new ApiRequest('ban', 'get');
    listRequest.data({format: 'json'});
    listRequest.onSuccess(refreshData);
    var list = $('#ipbanlist_list');

    function refreshData(data)
    {
        data = eval('(' + data + ')');
        data = data.ip;
        list.html('');
        if (data.length == 0)
        {
            var li = $('<li>');
            li.text('<?php $lang->nobannedips ?>');
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
    
    $('#ipbanlist').bind('pagecreate', function(){
        $('#ipbanlist_toolbar_button').bind('vmousedown', function(){
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