<ul data-role="listview">
    <li data-role="divider" data-theme="e">Home</li>
    <li class="arrow"><a href="<?php echo $this->createUrl('user/register') ?>"><?php echo Yii::t('registration', 'Registration') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('user/login') ?>"><?php echo Yii::t('login', 'Login') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('user/logout') ?>" data-ajax="false">Debug: <?php echo Yii::t('home', 'Logout') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('server/list') ?>" data-ajax="false">Debug: <?php echo Yii::t('home', 'Servers') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('stats') ?>"><?php echo Yii::t('stats', 'Statistics') ?></a></li>
    <li class="arrow"><a href="<?php echo $this->createUrl('downloads') ?>"><?php echo Yii::t('downloads', 'Downloads') ?></a></li>
</ul>