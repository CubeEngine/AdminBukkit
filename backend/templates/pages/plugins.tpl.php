<?php $lang = Lang::instance('plugins') ?>
<ol id="pluginlist" data-role="listview">
    <li>Pluginliste wird geladen...</li> <!-- @todo static language -->
</ol>

<script type="text/javascript">
    var list = $('#pluginlist');
    var request = new ApiRequest('plugin', 'list');
    request.ignoreFirstFail(true);
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
            li.innerHTML = '<?php $lang->noplugins ?>';
            list.appendChild(li);
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
                a.click(linkHandler);
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
    
    $('#plugins_load').click(function(){
        alert(genericLang.function_disabled);
        return false;
        
        var pluginName = prompt('<?php $lang->pluginfilename ?>', '');
        if (!pluginName)
        {
            return false;
        }
        pluginName = pluginName.replace(/\.jar$/i, '');
        var loadRequest = new ApiRequest('plugin', 'load');
        loadRequest.onSuccess(function(){
            request.execute();
        });
        request.onFailure(function(code){
            switch (code)
            {
                case 1:
                    alert('<?php $lang->noplugin ?>');
                    break;
                case 2:
                    alert('<?php $lang->failedtoload ?>');
                    break;
                case 3:
                    alert('<?php $lang->invalidplugin ?>');
                    break;
                case 4:
                    alert('<?php $lang->invaliddescription ?>');
                    break;
                case 5:
                    alert('<?php $lang->missingdependency ?>');
                    break;
            }
        });
        loadRequest.execute({plugin: pluginName});
        return false;
    });
    $('#plugins_reloadall').click(function(){
        if (confirm('<?php $lang->confirm_reloadall ?>'))
        {
            var reloadAllRequest = new ApiRequest('plugin', 'reload');
            reloadAllRequest.onSuccess(function(){
                alert('<?php $lang->reload_success ?>');
                request.execute();
            });
            reloadAllRequest.execute();
        }
        return false;
    });
</script>