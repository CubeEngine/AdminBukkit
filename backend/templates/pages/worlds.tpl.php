<?php $lang = Lang::instance('worlds') ?>
<div>
    <a href="<?php $this->page('addworld') ?>" data-rel="dialog" data-transition="pop" id="world_create"><?php $lang->create ?></a>
</div>
<h2><?php $lang->loadedworlds ?>:</h2>
<ul id="worldlist" data-role="listview" data-split-icon="gear">
    <li><?php $lang->loadinglist ?></li>
</ul>
<script type="text/javascript">
    var oldData = null;
    var list = $('#worldlist');
    var request = new ApiRequest('world', 'list');
    request.data({
        format: 'json'
    });
    request.onSuccess(refreshData);
    
    function refreshData(data)
    {
        var worlds = eval('(' + data + ')');
        if (!isDataDifferent(oldData, worlds))
        {
            return;
        }
        oldData = worlds;
        list.html('');
        if (data == '')
        {
            list.append($('<li><?php $lang->noworlds ?></li>'));
        }
        else
        {
            worlds = worlds.sort(realSort);
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
    }).bind('pagecreate', function(){
        $('#worlds_toolbar_button').bind('vmousedown', function(){
            request.execute();
            return false;
        });
    });
</script>