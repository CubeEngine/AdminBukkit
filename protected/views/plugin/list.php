<ol data-filter="true" id="plugin_list_pluginlist" data-role="listview">
    <li><?php echo Yii::t('plugin', 'Pluginlist is loading...') ?></li>
</ol>

<script type="text/javascript">
    (function(){
        var list = $('#plugin_list_pluginlist');
        var request = new ApiRequest('plugin', 'list');
        request.data({
            format: 'json'
        });
        request.onSuccess(refreshData);
        var oldData = null;

        function refreshData(plugins)
        {
            if (!AdminBukkit.isDataDifferent(oldData, plugins))
            {
                return;
            }
            oldData = plugins;
            list.html('');
            if (plugins.length == 0)
            {
                list.append($('<li><?php echo Yii::t('plugin', 'No plugins available') ?></li>'));
            }
            else
            {
                plugins = plugins.sort(AdminBukkit.realSort);
                for (var i = 0; i < plugins.length; i++)
                {
                    var li = $('<li>');
                    var a = $('<a>');
                    a.text(plugins[i]);
                    a.attr('href', '<?php echo $this->createUrl('plugin/view') ?>?plugin=' + plugins[i]);
                    li.append(a);
                    list.append(li);
                }
                list.listview('refresh');
            }
        }

        $('#plugin_list').bind('pageshow', function(){
            request.execute();
        }).bind('pagecreate', function(){
            $('#toolbar_plugin_list_refresh').click(function(){
                request.execute();
                return false;
            });
        });
    })();
</script>