<?php $lang = Lang::instance('profile') ?>
<h2><?php $lang->userinfos ?>:</h2>
<ul class="rounded">
    <li><?php $lang->username ?>: <?php echo $username ?></li>
    <li><?php $lang->email ?>: <?php echo $email ?></li>
    <li><?php $lang->apiaddr ?>: <?php echo $host . ':' . $port ?></li>
    <li><?php $lang->apipass ?>: <?php echo htmlspecialchars($pass) ?></li>
</ul>