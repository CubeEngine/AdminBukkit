<?php $lang = Lang::instance('worlds') ?>
<ul class="rounded">
    <li><a href="#" id="world_create"><?php $lang->create ?></a></li>
</ul>
<h2><?php $lang->loadedworlds ?>:</h2>
<ul id="worldlist" data-role="listview">
    <li><?php $lang->loadinglist ?></li>
</ul>
<?php $this->displayTemplateFile('generic/worldutils') ?>
<script type="text/javascript">
    var list = $('#worldlist');
    var request = new ApiRequest('world', 'list');
    request.ignoreFirstFail(true);
    request.onSuccess(refreshData);
    request.onFailure(function(){
        alert('failed to load list'); // @todo static language
    });
    
    function refreshData(data)
    {
        list.html('');
        if (data == '')
        {
            var li = $('<li>');
            li.innerHTML = '<?php $lang->noworlds ?>';
            list.append(li);
        }
        else
        {
            var worlds = data.split(',').sort(realSort);
            for (var i = 0; i < worlds.length; i++)
            {
                var li = $('<li>');
                var mainLink = $('<a>');
                mainLink.text(worlds[i]);
                mainLink.attr('href', '<?php $this->page('world') ?>?world=' + worlds[i]);
                li.append(mainLink);
                var minorLink = $('<a>');
                minorLink.attr('href', '<?php $this->page('worldpopup') ?>');
                li.append(minorLink);
                list.append(li);
            }
            list.listview('refresh');
        }
    }
    
    $('#worlds').bind('pageshow', function(){
        request.execute();
    });

    $('div.toolbar a.button').click(function(){
        request.execute();
        return false;
    });
    $('#world_create').click(function(){
        world_create(request.execute);
    });
    $('#world_time').click(function(){
        world_time(world);
        return false;
    });
    $('#world_pvp').click(function(){
        world_pvp(world);
        return false;
    });
    $('#world_storm').click(function(){
        world_storm(world)
        return false;
    });
    $('#world_spawn').click(function(){
        world_spawn(world);
        return false;
    });
    $('#world_info').click(function(){
        redirectTo('<?php $this->page('world') ?>?world=' + world);
        return false;
    });
    $('#world_playerlist').click(function(){
        redirectTo('<?php $this->page('players') ?>?world=' + world);
        return false;
    });

</script>