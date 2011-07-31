<?php $lang = Lang::instance('playerutils') ?>
<div id="player_overlay" class="overlay">
    <div id="player_scroller">
        <div>
            <ul class="rounded">
                <li class="arrow"><a href="#" id="player_info"><?php $lang->infos ?></a></li>
                <li><a href="#" id="player_kick"><?php $lang->kick ?></a></li>
                <li><a href="#" id="player_ban"><?php $lang->ban ?></a></li>
                <li><a href="#" id="player_teleport"><?php $lang->teleport ?></a></li>
                <li><a href="#" id="player_tell"><?php $lang->tell ?></a></li>
                <li><a href="#" id="player_burn"><?php $lang->burn ?></a></li>
                <li><a href="#" id="player_heal"><?php $lang->heal ?></a></li>
                <li><a href="#" id="player_kill"><?php $lang->kill ?></a></li>
                <li><a href="#" id="player_clearinv"><?php $lang->clearinv ?></a></li>
                <li><a href="#" id="player_give"><?php $lang->give ?></a></li>
                <li><a href="#" id="player_op"><?php $lang->op ?></a></li>
                <li><a href="#" id="player_deop"><?php $lang->deop ?></a></li>
            </ul>
            <ul class="rounded">
                <li><a href="#" class="toggleoverlay"><?php $lang->close ?></a></li>
            </ul>
        </div>
            <div class="spacer"></div>
    </div>
</div>
<script type="text/javascript" src="backend/javascriptlang.php?file=playerutils"></script>
<script type="text/javascript" src="js/playerutils.js"></script>
<script type="text/javascript" src="backend/javascriptlang.php?file=serverutils"></script>
<script type="text/javascript" src="js/serverutils.js"></script>
<script type="text/javascript" src="js/overlay.js"></script>
<script type="text/javascript" src="js/iscroll-lite.min.js"></script>
<script type="text/javascript">
    var scroller = new iScroll('player_overlay');
    var playerOverlay = new Overlay('#player_overlay');
    playerOverlay.getElement().bind('openOverlay', function(e, event){
        window.scroll(0, 0);
        scroller.refresh();
        scroller.scrollTo(0, 0);
        var scrollElem = event.getElement().find('div:first');
        scrollElem.height(scrollElem.height() + 10)
    });
</script>
