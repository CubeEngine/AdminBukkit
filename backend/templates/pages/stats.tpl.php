<?php $lang = Lang::instance('stats') ?>
<?php if (count($stats['user'])): ?>
<h2><?php $lang->userstats ?>:</h2>
<ul class="rounded">
    <?php foreach ($stats['user'] as $stat):  ?>
    <li><?php $lang->outParsed('stat_' . $stat['index'], array($stat['value'])) ?></li>
    <?php endforeach ?>
</ul>
<?php endif ?>
<h2><?php $lang->apistats ?>:</h2>
<ul class="rounded">
    <?php if (count($stats['user'])): ?>
    <?php foreach ($stats['api_success'] as $stat):  ?>
    <li><?php $lang->outParsed('stat_' . $stat['index'], array($stat['value'])) ?></li>
    <?php endforeach ?>
    <?php endif ?>
    <li><?php $lang->failed_requests($stats['api_fails']) ?></li>
</ul>
<h2><?php $lang->downloads ?>:</h2>
<?php if (count($stats['downloaded'])): ?>
<ul class="rounded">
    <?php foreach ($stats['downloaded'] as $file):  ?>
    <li><?php $lang->outParsed('filedownloaded', array($file['index'], $file['value'])) ?></li>
    <?php endforeach ?>
</ul>
<?php endif ?>