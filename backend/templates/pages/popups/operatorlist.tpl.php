<?php $lang = Lang::instance('operatorlist') ?>
<ul id="operatorlist_list" data-role="listview" data-filter="true">
    <li><?php $lang->loading ?></li>
</ul>
<script type="text/javascript" src="<?php echo Router::instance()->getBasePath() ?>backend/javascriptlang.php?file=serverutils"></script>
<script type="text/javascript" src="<?php $this->res('js/serverutils.js') ?>"></script>
<script type="text/javascript">
    var listRequest = new ApiRequest('operator', 'get');
    listRequest.data({format: 'json'});
    listRequest.onSuccess(refreshData);
    var list = $('#operatorlist_list');

    function refreshData(data)
    {
        data = eval('(' + data + ')');
        list.html('');
        if (data.length == 0)
        {
            var li = $('<li>');
            li.text('<?php $lang->noops ?>');
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
                mainLink.click(deop);
                li.append(mainLink);
                list.append(li);
            }
        }
        list.listview('refresh');
    }

    function deop(e)
    {
        e.preventDefault();
        if (operator_remove(e.target.innerHTML, true))
        {
            listRequest.execute();
        }
    }

    $('#operatorlist').bind('pagecreate', function(){
        $('#operatorlist_toolbar_button').bind('vmousedown', function(){
            if (operator_add(null, true))
            {
                listRequest.execute();
            }
            return false;
        });
    }).bind('pageshow', function(){
        listRequest.execute();
    });
</script>