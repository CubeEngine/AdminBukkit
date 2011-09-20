<?php $lang = Lang::instance('downloads') ?>
<ul data-role="listview">
    <li data-role="divider" data-theme="e"><?php $lang->baseplugin ?></li>
    <li><a target="_blank" class="download" href="<?php $this->page('downloads') ?>?file=ApiBukkit.jar">ApiBukkit</a></li>

    <li data-role="divider" data-theme="e"><?php $lang->apiplugins ?></li>
    <li><a target="_blank" class="download" href="<?php $this->page('downloads') ?>?file=BasicApi.jar">BasicApi</a></li>
</ul>
<!--
<script type="text/javascript">
    $('#downloads a.download').click(function(e){
        //document.location.href = $(e.target).attr('href');
        window.open($(e.target).attr('href'));
        $('#message li:first').text('<?php $lang->downloaded ?>');
        $('#message').toggle();
        setTimeout(function(){
            $('#message').toggle('slow');
        }, 5000);
        e.preventDefault();
    });
</script>
-->