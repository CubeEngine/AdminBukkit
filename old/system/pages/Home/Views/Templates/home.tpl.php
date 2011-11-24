<?php $lang = Lang::instance('home') ?>
<ul data-role="listview">
    <li data-role="divider" data-theme="e"><?php $lang->pages ?></li>
    <?php if (!User::currentlyLoggedIn()): ?>
    <li class="arrow"><a href="<?php $this->page('register') ?>"><?php $lang->registration ?></a></li>
    <li class="arrow"><a href="<?php $this->page('login') ?>"><?php $lang->login ?></a></li>
    <li class="arrow"><a href="<?php $this->page('stats') ?>"><?php $lang->stats ?></a></li>
    <li class="arrow"><a href="<?php $this->page('downloads') ?>"><?php $lang->downloads ?></a></li>
    <?php else: ?>
    <li class="arrow"><a href="<?php $this->page('server') ?>"><?php $lang->serverinfo ?></a></li>
    <li class="arrow"><a href="<?php $this->page('players') ?>"><?php $lang->manplayers ?></a></li>
    <li class="arrow"><a href="<?php $this->page('worlds') ?>"><?php $lang->manworlds ?></a></li>
    <li class="arrow"><a href="<?php $this->page('plugins') ?>"><?php $lang->manplugins ?></a></li>
    <li class="arrow"><a href="<?php $this->page('stats') ?>"><?php $lang->stats ?></a></li>
    <li class="arrow"><a href="<?php $this->page('downloads') ?>"><?php $lang->downloads ?></a></li>

    <li data-role="divider" data-theme="e"><?php $lang->user ?></li>
    <li class="arrow"><a href="<?php $this->page('profile') ?>"><?php $lang->profile ?></a></li>
    <li class="arrow"><a href="<?php $this->page('logout') ?>" id="logout"><?php $lang->logout ?></a></li>
    <?php endif ?>
</ul>
<script type="text/javascript">
    $('#logout').click(function(){
        return confirm('<?php $lang->confirm_logout ?>');
    });
</script>