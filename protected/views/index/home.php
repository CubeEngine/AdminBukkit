<ul data-role="listview">
    <li data-role="divider" data-theme="e"><?php echo Yii::t('home', 'Home') ?></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('server/view') ?>"><?php echo Yii::t('home', 'Server-Information') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('player/list') ?>"><?php echo Yii::t('home', 'Player-Managements') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('world/list') ?>"><?php echo Yii::t('home', 'World-Management') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('plugin/list') ?>"><?php echo Yii::t('home', 'Plugin-Management') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('stats') ?>"><?php echo Yii::t('home', 'Statistics') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('downloads') ?>"><?php echo Yii::t('home', 'Downloads') ?></a></li>

    <li data-role="divider" data-theme="e">User</li>
    <li class="arrow"><a href="<?php echo $this->createUrl('server/list') ?>"><?php echo Yii::t('server', 'Serverlist') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('profile/index') ?>"><?php echo Yii::t('profile', 'Profile') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('user/logout') ?>" id="logout" data-ajax="false"><?php echo Yii::t('home', 'Logout') ?></a></li>
</ul>
<script type="text/javascript">
    $('#logout').click(function(){
        return confirm('<?php echo Yii::t('home', 'Do you really want to logout?') ?>');
    });
</script>