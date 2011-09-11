<input type="text" id="operatorlist_input">
<input type="button" id="operatorlist_submit" value="<?php $lang->submit ?>">
<ul data-role="listview" data-filter="true">
    <li><?php $lang->loading ?></li>
</ul>
<script type="text/javascript">
    $('#operatorlist').bind('pageshow', function(){

    }).bind('pagehide', function(){

    });
</script>