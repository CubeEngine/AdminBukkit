<?php $user = User::get($user) ?>
<!--<h2><?php //$lang->userinfos ?>:</h2>-->
<ul data-role="listview" data-inset="true">
    <li>
        <?php echo Yii::t('profile', 'Username') ?>:
        <span class="value"><?php echo $user->getName() ?></span>
    </li>
    <li>
        <?php echo Yii::t('profile', 'Email-address') ?>:
        <span class="value"><?php echo $user->getEmail() ?></span>
    </li>
    <?php if ($user->getSelectedServer() != null): ?>
        <li>
            <a href="<?php echo $this->createUrl('server/view', array('id' => $user->getSelectedServer()->getId())) ?>">
                <?php echo Yii::t('profile', 'Current server') ?>: <span class="value"><?php echo $user->getSelectedServer()->getAlias() ?></span>
            </a>
        </li>
    <?php endif ?>
    <li>
        <a href="<?php echo $this->createUrl('server/list') ?>"><?php echo Yii::t('server', 'Servers') ?></a>
    </li>
</ul>

<a data-role="button" data-rel="dialog" href="<?php echo $this->createUrl('profile/delete') ?>"><?php echo Yii::t('profile', 'Delete your account') ?></a>