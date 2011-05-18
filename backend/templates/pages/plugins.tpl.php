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
    
    $('div.toolbar a.button').click(function(){
        refreshData();
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
        apiCall('plugin', 'load', function(){}, {plugin: pluginName});
        return false;
    });
    $('#plugins_reloadall').click(function(){
        if (confirm('<?php $lang->confirm_reloadall ?>'))
        {
            apiCall('plugin', 'reloadall', function(){
                alert('<?php $lang->reload_success ?>');
            });
        }
        return false;
    });
    
    function refreshData()
    {
        var list = document.getElementById('pluginlist');
        apiCall('plugin', 'list', function(data){
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
        });
    }
    
    function init()
    {
        refreshData();
    }
</script>