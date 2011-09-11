<?php $lang = Lang::instance('worlds') ?>
<div>
    <a href="#" id="world_create"><?php $lang->create ?></a>
</div>
<h2><?php $lang->loadedworlds ?>:</h2>
<ul id="worldlist" data-role="listview" data-split-icon="gear">
    <li><?php $lang->loadinglist ?></li>
</ul>
<script type="text/javascript">
    var list = $('#worldlist');
    var request = new ApiRequest('world', 'list');
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
            li.text('<?php $lang->noworlds ?>');
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
                minorLink.attr('href', '<?php $this->page('worldpopup') ?>?world=' + worlds[i]);
                li.append($('<a href="<?php $this->page('worldpopup') ?>?world=' + worlds[i] + '" data-rel="dialog" data-transition="pop"></a>'));
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

</script>