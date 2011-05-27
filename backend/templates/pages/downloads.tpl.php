<?php $lang = Lang::instance('downloads') ?>
<ul id="message" style="display:none" class="rounded">
    <li></li>
</ul>
<h2><?php $lang->baseplugin ?>:</h2>
<ul class="rounded">
    <li class="arrow"><a class="download" href="downloads.html?file=ApiBukkit.jar">ApiBukkit</a></li>
</ul>
<h2><?php $lang->apiplugins ?></h2>
<ul class="rounded">
    <li class="arrow"><a class="download" href="downloads.html?file=BasicApi.jar">BasicApi</a></li>
</ul>
<script type="text/javascript">
    $('a.download').click(function(e){
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