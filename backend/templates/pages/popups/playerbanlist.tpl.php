<input type="text" id="playerbanlist_input">
<input type="button" id="playerbanlist_submit" value="<?php $lang->submit ?>">
<ul data-role="listview" data-filter="true">
    <li><?php $lang->loading ?></li>
</ul>
<script type="text/javascript">
    $('#playerbanlist').bind('pageshow', function(){

    }).bind('pagehide', function(){

    });
</script>