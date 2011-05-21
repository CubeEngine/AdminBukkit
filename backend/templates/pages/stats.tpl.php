<?php $lang = Lang::instance('stats') ?>
<h2><?php $lang->userstats ?>:</h2>
<ul class="rounded">
    <?php foreach ($stats['user'] as $stat):  ?>
    <li><?php $lang->outParsed('stat_' . $stat['index'], array($stat['value'])) ?></li>
    <?php endforeach ?>
</ul>
<h2><?php $lang->apistats ?>:</h2>
<ul class="rounded">
    <?php foreach ($stats['api_success'] as $stat):  ?>
    <li><?php $lang->outParsed('stat_' . $stat['index'], array($stat['value'])) ?></li>
    <?php endforeach ?>
    <li><?php $lang->failed_requests($stats['api_fails']) ?></li>
</ul>