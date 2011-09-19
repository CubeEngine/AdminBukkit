<?php $lang = Lang::instance('stats') ?>
<ul data-role="listview">
<?php if (count($stats['user'])): ?>
    <li data-role="divider" data-theme="e"><?php $lang->userstats ?></li>
    <?php foreach ($stats['user'] as $stat):  ?>
    <li><?php $lang->outParsed('stat_' . $stat['index'], array($stat['value'])) ?></li>
    <?php endforeach ?>
<?php endif ?>
<?php if (count($stats['user'])): ?>
    <li data-role="divider" data-theme="e"><?php $lang->apistats ?></li>
    <?php foreach ($stats['api_success'] as $stat):  ?>
    <li><?php $lang->outParsed('stat_' . $stat['index'], array($stat['value'])) ?></li>
    <?php endforeach ?>
<?php endif ?>
<li><?php $lang->failed_requests($stats['api_fails']) ?></li>
<?php if (count($stats['downloaded'])): ?>
    <li data-role="divider" data-theme="e"><?php $lang->downloads ?></li>
    <?php foreach ($stats['downloaded'] as $file):  ?>
        <li><?php $lang->outParsed('filedownloaded', array($file['index'], $file['value'])) ?></li>
    <?php endforeach ?>
</ul>
<?php endif ?>