<input type="text" id="ipbanlist_input">
<input type="button" id="ipbanlist_submit" value="<?php $lang->submit ?>">
<ul data-role="listview" data-filter="true">
    <li><?php $lang->loading ?></li>
</ul>
<script type="text/javascript">
    $('#ipbanlist').bind('pageshow', function(){

    }).bind('pagehide', function(){

    });
</script>