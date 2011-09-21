<?php $lang = Lang::instance('plugins') ?>
<ol data-filter="true" id="pluginlist" data-role="listview">
    <li><?php $lang->loadinglist ?></li>
</ol>

<script type="text/javascript">
    var list = $('#pluginlist');
    var request = new ApiRequest('plugin', 'list');
    request.data({
        format: 'json'
    });
    request.onSuccess(refreshData);
    var oldData = null;
    
    function refreshData(data)
    {
        var plugins = eval('(' + data + ')');
        if (!isDataDifferent(oldData, plugins))
        {
            return;
        }
        oldData = plugins;
        list.html('');
        if (data == '')
        {
            list.append($('<li><?php $lang->noplugins ?></li>'));
        }
        else
        {
            plugins = plugins.sort(realSort);
            for (var i = 0; i < plugins.length; i++)
            {
                var li = $('<li>');
                var a = $('<a>');
                a.text(plugins[i]);
                a.attr('href', '<?php $this->page('plugin') ?>?plugin=' + plugins[i]);
                li.append(a);
                list.append(li);
            }
            list.listview('refresh');
        }
    }
    
    $('#plugins').bind('pageshow', function(){
        request.execute();
    }).bind('pagecreate', function(){
        $('#plugins_toolbar_button').click(function(){
            request.execute();
            return false;
        });
    });
</script>