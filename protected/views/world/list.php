<div>
    <a href="<?php echo $this->createUrl('world/add') ?>" data-rel="dialog" id="world_create"><?php echo Yii::t('world', 'Create a new world') ?></a>
</div>
<h2><?php echo Yii::t('world', 'Loaded Worlds') ?>:</h2>
<ul id="world_worldlist" data-role="listview" data-split-icon="gear">
    <li><?php echo Yii::t('world', 'List is loading...') ?></li>
</ul>
<script type="text/javascript">
    var oldData = null;
    var list = $('#world_worldlist');
    var request = new ApiRequest('world', 'list');
    request.data({
        format: 'json'
    });
    request.onSuccess(refreshData);
    
    function refreshData(worlds)
    {
        if (!AdminBukkit.isDataDifferent(oldData, worlds))
        {
            return;
        }
        oldData = worlds;
        list.html('');
        if (worlds.length == 0)
        {
            list.append($('<li><?php echo Yii::t('world', 'No worlds are available') ?></li>'));
        }
        else
        {
            worlds = worlds.sort(AdminBukkit.realSort);
            for (var i = 0; i < worlds.length; i++)
            {
                var li = $('<li>');
                var mainLink = $('<a>');
                mainLink.text(worlds[i]);
                mainLink.attr('href', '<?php echo $this->createUrl('world/view') ?>?world=' + worlds[i]);
                li.append(mainLink);
                var minorLink = $('<a>');
                minorLink.attr('href', '<?php echo $this->createUrl('world/utils') ?>?world=' + worlds[i]);
                li.append($('<a href="<?php echo $this->createUrl('world/utils') ?>?world=' + worlds[i] + '" data-rel="dialog"></a>'));
                list.append(li);
            }
            list.listview('refresh');
        }
    }
    
    $('#world_list').bind('pageshow', function(){
        request.execute();
    }).bind('pagecreate', function(){
        $('#toolbar_world_list_refresh').click(function(){
            request.execute();
            return false;
        });
    });
</script>
