<?php $lang = Lang::instance('profile') ?>
<h2><?php $lang->userinfos ?>:</h2>
<ul data-role="listview" data-inset="true">
    <li><?php $lang->username ?>: <span class="value"><?php echo $username ?></span></li>
    <li><?php $lang->email ?>: <span class="value"><?php echo $email ?></span></li>
    <li><?php $lang->apiaddr ?>: <span class="value"><?php echo $host . ':' . $port ?></span></li>
    <li><?php $lang->apipass ?>: <span class="value"><?php echo htmlspecialchars($pass) ?></span></li>
</ul>