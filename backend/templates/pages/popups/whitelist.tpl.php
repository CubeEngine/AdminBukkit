<?php $lang = Lang::instance('whitelist') ?>
<ul id="whitelist_list" data-role="listview" data-filter="true">
    <li><?php $lang->loading ?></li>
</ul><script type="text/javascript" src="<?php echo Router::instance()->getBasePath() ?>backend/javascriptlang.php?file=serverutils"></script>
<script type="text/javascript" src="<?php $this->res('js/serverutils.js') ?>"></script>
<script type="text/javascript">
    var listRequest = new ApiRequest('whitelist', 'get');
    listRequest.data({format: 'json'});
    listRequest.onSuccess(refreshData);
    var list = $('#whitelist_list');

    function refreshData(data)
    {
        data = eval('(' + data + ')');
        list.html('');
        if (data.length == 0)
        {
            var li = $('<li>');
            li.text('<?php $lang->empty ?>');
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
                mainLink.click(unwhitelist);
                li.append(mainLink);
                list.append(li);
            }
        }
        list.listview('refresh');
    }

    function unwhitelist(e)
    {
        e.preventDefault();
        if (whitelist_remove(e.target.innerHTML, true))
        {
            listRequest.execute();
        }
    }

    $('#whitelist').bind('pageshow', function(){
        $('#whitelist_toolbar_button').bind('vmousedown', function(){
            if (whitelist_add(null, true))
            {
                listRequest.execute();
            }
            return false;
        });
        listRequest.execute();
    }).bind('pagehide', function(){

    });
</script>