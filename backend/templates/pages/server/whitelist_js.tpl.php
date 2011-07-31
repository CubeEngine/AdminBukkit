<?php $lang = Lang::instance('server') ?>
<!-- whitelist -->
<script type="text/javascript">

    $('#whitelist').click(function(){
        $('#generic_add').text('<?php $lang->addtowhitelist ?>').click(function(e){
            e.preventDefault();
            if (whitelist_add(null, true))
            {
                genericApiRequest.execute();
            }
        });
        $('#generic_headline').text('<?php $lang->whitelist ?>');
        genericApiRequest = new ApiRequest('operator', 'get');
        genericApiRequest.data({format:'json'});
        genericApiRequest.onSuccess(loadWhitelist);
        genericOverlay.toggle();
        return false;
    });

    function removeFromWhitelist(e)
    {
        e.preventDefault();
        whitelist_remove(e.target.innerHTML);
    }

    function loadWhitelist(data)
    {
        data = eval('(' + data + ')');
        genericList.html('');
        if (data.length == 0)
        {
            var li = document.createElement('li');
            li.innerHTML = '<?php $lang->emptyWhitelist ?>';
            genericList.append(li);
        }
        else
        {
            var data = data.sort(realSort);
            for (var i = 0; i < data.length; i++)
            {
                var li = document.createElement('li');
                var a = document.createElement('a');
                a.innerHTML = data[i];
                a.href = '#';
                $(a).click(removeFromWhitelist);
                li.appendChild(a);
                genericList.append(li);
            }
        }
    }
</script>