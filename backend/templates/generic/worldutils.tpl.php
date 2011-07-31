<?php $lang = Lang::instance('worldutils') ?>
<div id="world_overlay" class="overlay">
    <div id="world_scroller">
        <div>
            <ul class="rounded">
                <li class="arrow"><a href="#" id="world_info"><?php $lang->infos ?></a></li>
                <li class="arrow"><a href="#" id="world_playerlist"><?php $lang->playerlist ?></a></li>
                <li><a href="#" id="world_time"><?php $lang->time ?></a></li>
                <li><a href="#" id="world_storm"><?php $lang->storm ?></a></li>
                <li><a href="#" id="world_pvp"><?php $lang->pvp ?></a></li>
                <li><a href="#" id="world_spawn"><?php $lang->spawn ?></a></li>
                <!--
                <li><a href="#" id="world_weather"><?php $lang->weather ?></a></li>
                <li><a href="#" id="world_thunder"><?php $lang->thunder ?></a></li>
                -->
            </ul>
            <ul class="rounded">
                <li><a href="#" class="toggleoverlay"><?php $lang->close ?></a></li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript" src="backend/javascriptlang.php?file=worldutils"></script>
<script type="text/javascript" src="js/worldutils.js"></script>
<script type="text/javascript" src="js/overlay.js"></script>
<script type="text/javascript" src="js/iscroll-lite.min.js"></script>
<script type="text/javascript">
    var scroller = new iScroll('world_overlay');
    var worldOverlay = new Overlay('#world_overlay');
    worldOverlay.getElement().bind('openOverlay', function(e, event){
        window.scroll(0, 0);
        scroller.refresh();
        scroller.scrollTo(0, 0);
        var scrollElem = event.getElement().find('div:first');
        scrollElem.height(scrollElem.height() + 10)
    });
</script>