<?php $lang = Lang::instance('profile') ?>
<h2><?php $lang->userinfos ?>:</h2>
<ul data-role="listview" data-inset="true">
    <li><?php $lang->username ?>: <span class="value"><?php echo $username ?></span></li>
    <li><?php $lang->email ?>: <span class="value"><?php echo $email ?></span></li>
    <li><a href="<?php $this->page('viewserver') ?>?id=<?php echo $currentserver->getId() ?>"><?php $lang->currentserver ?>: <span class="value"><?php echo $currentserver->getAlias() ?></span></a></li>
</ul>
<?php if (count($servers)): ?>
    <h2><?php $lang->servers ?>:</h2>
    <ul data-role="listview" data-inset="true">
        <?php foreach ($servers as $server): ?>
            <?php
                try
                {
                    $server = Server::get($server);
                }
                catch (Exception $e)
                {
                    continue;
                }
            ?>
            <li><a href="<?php $this->page('viewserver') ?>?id=<?php echo $server->getId() ?>"><?php echo $server->getAlias() ?></a></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>
<button type="button"><?php echo $lang->deleteUser ?></button>