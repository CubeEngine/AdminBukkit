<ul id="operatorlist_list" data-role="listview" data-filter="true">
    <li><?php echo Yii::t('generic', 'Loading...') ?></li>
</ul>
<script type="text/javascript" src="<?php echo $this->createUrl('javascript/translation', array('cat' => 'serverutils')) ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/res/js/serverutils.js"></script>
<script type="text/javascript">
    var listRequest = new ApiRequest('operator', 'get');
    listRequest.data({format: 'json'});
    listRequest.onSuccess(refreshData);
    var list = $('#operatorlist_list');

    function refreshData(data)
    {
        //data = eval('(' + data + ')');
        list.html('');
        if (data.length == 0)
        {
            var li = $('<li>');
            li.text('<?php echo Yii::t('server', 'There are no operators.') ?>');
            list.append(li);
        }
        else
        {
            for (var i = 0; i < data.length; i++)
            {
                var li = $('<li>');
                var mainLink = $('<a>');
                mainLink.text(data[i]);
                mainLink.attr('href', '#');
                mainLink.click(deop);
                li.append(mainLink);
                list.append(li);
            }
        }
        list.listview('refresh');
    }

    function deop(e)
    {
        e.preventDefault();
        if (operator_remove(e.target.innerHTML, true))
        {
            listRequest.execute();
        }
    }

    $('#server_operators').bind('pagecreate', function(){
        $('#toolbar_server_op').click(function(){
            if (operator_add(null, true))
            {
                listRequest.execute();
            }
            return false;
        });
    }).bind('pageshow', function(){
        listRequest.execute();
    });
</script>