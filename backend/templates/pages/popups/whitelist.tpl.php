<input type="text" id="whitelist_input">
<input type="button" id="whitelist_submit" value="<?php $lang->submit ?>">
<ul data-role="listview" data-filter="true">
    <li><?php $lang->loading ?></li>
</ul>
<script type="text/javascript">
    $('#whitelist').bind('pageshow', function(){

    }).bind('pagehide', function(){

    });
</script>