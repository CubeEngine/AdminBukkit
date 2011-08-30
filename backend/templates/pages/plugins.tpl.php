<?php $lang = Lang::instance('plugins') ?>
<ol id="pluginlist" data-role="listview">
    <li>Pluginliste wird geladen...</li> <!-- @todo static language -->
</ol>

<script type="text/javascript">
    var list = $('#pluginlist');
    var request = new ApiRequest('plugin', 'list');
    request.onSuccess(refreshData);
    request.onFailure(function(){
        alert('failed to load list!'); // @todo static language
    });
    
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
    });
    
    $('div.toolbar a:last-child').click(function(){
        request.execute();
        return false;
    });
</script>