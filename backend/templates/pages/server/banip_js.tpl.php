<?php $lang = Lang::instance('server') ?>
<!-- ban ip -->
<script type="text/javascript">

    $('#banip').click(function(){
        $('#generic_add').text('<?php $lang->banip ?>').click(function(e){
            e.preventDefault();
            if (ban_ip(null, true))
            {
                genericApiRequest.execute();
            }
        });
        $('#generic_headline').text('<?php $lang->banned_ips ?>:');
        genericApiRequest = new ApiRequest('ban', 'get');
        genericApiRequest.data({format:'json'});
        genericApiRequest.onSuccess(loadIpBanList);
        genericOverlay.toggle();
        return false;
    });

    function unbanIpFromList(e)
    {
        e.preventDefault();
        unban_ip(e.target.innerHTML);
    }

    function loadIpBanList(data)
    {
        data = eval('(' + data + ')');
        genericList.html('');
        if (data.ip.length == 0)
        {
            var li = document.createElement('li');
            li.innerHTML = '<?php $lang->noBannedIps ?>';
            genericList.append(li);
        }
        else
        {
            for (var i = 0; i < data.ip.length; i++)
            {
                var li = document.createElement('li');
                var a = document.createElement('a');
                a.innerHTML = data.ip[i];
                a.href = '#';
                $(a).click(unbanIpFromList);
                li.appendChild(a);
                genericList.append(li);
            }
        }
    }
</script>