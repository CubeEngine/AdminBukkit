<?php $lang = Lang::instance('server') ?>
<!-- operators -->
<script type="text/javascript">

    $('#operators').click(function(){
        $('#generic_add').text('<?php $lang->addoperator ?>').click(function(e){
            e.preventDefault();
            if (operator_add(null, true))
            {
                genericApiRequest.execute();
            }
        });
        $('#generic_headline').text('<?php $lang->operators ?>:');
        genericApiRequest = new ApiRequest('operator', 'get');
        genericApiRequest.data({format:'json'});
        genericApiRequest.onSuccess(loadOperatorBanList);
        genericOverlay.toggle();
        return false;
    });

    function deopPlayerFromList(e)
    {
        e.preventDefault();
        operator_remove(e.target.innerHTML);
    }

    function loadOperatorBanList(data)
    {
        data = eval('(' + data + ')');
        genericList.html('');
        if (data.length == 0)
        {
            var li = document.createElement('li');
            li.innerHTML = '<?php $lang->noOperatores ?>';
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
                $(a).click(deopPlayerFromList);
                li.appendChild(a);
                genericList.append(li);
            }
        }
    }
</script>