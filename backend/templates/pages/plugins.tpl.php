<?php $lang = Lang::instance('plugins') ?>
<ul class="rounded">
    <li><a id="plugins_load" href="#">Lade ein Plugin</a></li>
    <li><a id="plugins_reloadall" href="#">Lade alle Plugins neu</a></li>
</ul>
<h2>Plugins:</h2>
<ul class="rounded" id="pluginlist">
    <li>Pluginliste wird geladen...</li>
</ul>

<script type="text/javascript">
    var list = document.getElementById('pluginlist');
    var request = new ApiRequest('plugin', 'list');
    request.onSuccess(refreshData);
    request.onFailure(function(){
        alert('failed to load list!');
    });
    
    function refreshData(data)
    {
        list.innerHTML = '';
        if (data == '')
        {
            var li = document.createElement('li');
            li.innerHTML = '<?php $lang->noplugins ?>';
            list.appendChild(li)
        }
        else
        {
            var plugins = data.split(',');
            for (var i = 0; i < plugins.length; i++)
            {
                var li = document.createElement('li');
                li.setAttribute('class', 'arrow');
                var a = document.createElement('a');
                a.innerHTML = plugins[i];
                a.href = 'plugin.html?plugin=' + plugins[i];
                $(a).click(linkHandler);
                li.appendChild(a);
                list.appendChild(li);
            }
        }
    }
    
    function init()
    {
        request.execute();
    }
    
    $('div.toolbar a.button').click(function(){
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