<?php $lang = Lang::instance('server') ?>
<!-- ban player -->
<script type="text/javascript">

    $('#banplayer').click(function(){
        $('#generic_add').text('<?php $lang->banplayer ?>').click(function(e){
            e.preventDefault();
            if (ban_player(null, true))
            {
                genericApiRequest.execute();
            }
        });
        $('#generic_headline').text('<?php $lang->banned_players ?>:');
        genericApiRequest = new ApiRequest('ban', 'get');
        genericApiRequest.data({format:'json'});
        genericApiRequest.onSuccess(loadPlayerBanList);
        genericOverlay.toggle();
        return false;
    });

    function unbanPlayerFromList(e)
    {
        e.preventDefault();
        unban_player(e.target.innerHTML);
    }
    
    function loadPlayerBanList(data)
    {
        data = eval('(' + data + ')');
        genericList.html('');
        if (data.player.length == 0)
        {
            var li = document.createElement('li');
            li.innerHTML = '<?php $lang->noBannedPlayers ?>';
            genericList.append(li);
        }
        else
        {
            var data = data.player.sort(realSort);
            for (var i = 0; i < data.length; i++)
            {
                var li = document.createElement('li');
                var a = document.createElement('a');
                a.innerHTML = data[i];
                a.href = '#';
                $(a).click(unbanPlayerFromList);
                li.appendChild(a);
                genericList.append(li);
            }
        }
    }
</script>