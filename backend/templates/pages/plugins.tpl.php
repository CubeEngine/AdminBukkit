<?php $lang = Lang::instance('plugins') ?>
<ol data-filter="true" id="pluginlist" data-role="listview">
    <li><?php $lang->loadinglist ?></li>
</ol>

<script type="text/javascript">
    var list = $('#pluginlist');
    var request = new ApiRequest('plugin', 'list');
    request.onSuccess(refreshData);
    
    function refreshData(data)
    {
        list.html('');
        if (data == '')
        {
            var li = $('<li>');
            li.text('<?php $lang->noplugins ?>');
            list.append(li);
        }
        else
        {
            var plugins = data.split(',').sort(realSort);
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
        $('#plugins_toolbar_button').bind('vmousedown', function(){
            request.execute();
            return false;
        });
    });
</script>