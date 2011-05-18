<?php $lang = Lang::instance('worlds') ?>
<ul class="rounded">
    <li><a href="#" id="world_create"><?php $lang->create ?></a></li>
</ul>
<h2><?php $lang->loadedworlds ?>:</h2>
<ul id="worldlist" class="rounded">
    <li><?php $lang->loadinglist ?></li>
</ul>
<?php $this->displayTemplateFile('generic/worldutils') ?>
<script type="text/javascript">
    $('div.toolbar a.button').click(function(){
        refreshData();
        return false;
    });
    
    function refreshData()
    {
        var list = document.getElementById('worldlist');
        apiCall('world', 'list', function(data){
            list.innerHTML = '';
            if (data == '')
            {
                var li = document.createElement('li');
                li.innerHTML = '<?php $lang->noworlds ?>';
                list.appendChild(li)
            }
            else
            {
                var worlds = data.split(',');
                for (var i = 0; i < worlds.length; i++)
                {
                    var li = document.createElement('li');
                    li.setAttribute('class', 'arrow');
                    var a = document.createElement('a');
                    a.innerHTML = worlds[i];
                    a.href = '#';
                    $(a).click(overlayHandler);
                    li.appendChild(a);
                    list.appendChild(li);
                }
            }
        });
    }
    
    function overlayHandler(e)
    {
        world = e.target.innerHTML;
        toggleOverlay('#world_overlay');
        e.preventDefault();
    }
    
    function init()
    {
        prepareOverlay('#world_overlay');
        refreshData();
    }

    $('#world_create').click(world_create);
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
        redirectTo('world.html?world=' + world);
        return false;
    });
    $('#world_playerlist').click(function(){
        redirectTo('players.html?world=' + world);
        return false;
    });

</script>