<ul data-role="listview" data-inset="true">
    <li><?php echo Yii::t('server', 'Name') ?>: <span class="value"><?php echo $server->getAlias() ?></span></li>
    <li><?php echo Yii::t('server', 'Address') ?>: <span class="value"><?php echo $server->getHost() ?>:<?php echo $server->getPort() ?></span></li>
    <li><?php echo Yii::t('server', 'Authkey') ?>: <span class="value"><?php echo $server->getAuthKey() ?></span></li>
    <li><a href="<?php echo $this->createUrl('profile/view', array('id' => User::get($server->getOwner())->getId())) ?>"><?php echo Yii::t('server', 'Owner') ?>: <span class="value"><?php echo User::get($server->getOwner())->getName() ?></span></a></li>
    <li>
        <span><?php echo Yii::t('server', 'Members') ?><br /></span>
        <ul data-inset="true">
            <?php foreach ($server->getMembers() as $member): ?>
                <?php if (($user = User::get($member)) !== null): ?>
                    <li><a href="<?php echo $this->createUrl('profile/view', array('id' => $user->getId())) ?>"><?php echo $user->getName() ?></a></li>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
    </li>
</ul>
