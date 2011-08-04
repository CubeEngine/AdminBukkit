<?php $lang = Lang::instance('home') ?>
<h2><?php $lang->menu ?>:</h2>
<?php if (!User::loggedIn()): ?>
<ul class="rounded">
    <li class="arrow"><a href="<?php $this->page('register') ?>"><?php $lang->registration ?></a></li>
    <li class="arrow"><a href="<?php $this->page('login') ?>"><?php $lang->login ?></a></li>
    <li class="arrow"><a href="<?php $this->page('stats') ?>"><?php $lang->stats ?></a></li>
    <li class="arrow"><a href="<?php $this->page('downloads') ?>"><?php $lang->downloads ?></a></li>
</ul>
<?php else: ?>
<ul class="rounded">
    <li class="arrow"><a href="<?php $this->page('server') ?>"><?php $lang->serverinfo ?></a></li>
    <li class="arrow"><a href="<?php $this->page('players') ?>"><?php $lang->manplayers ?></a></li>
    <li class="arrow"><a href="<?php $this->page('worlds') ?>"><?php $lang->manworlds ?></a></li>
    <li class="arrow"><a href="<?php $this->page('plugins') ?>"><?php $lang->manplugins ?></a></li>
    <li class="arrow"><a href="<?php $this->page('stats') ?>"><?php $lang->stats ?></a></li>
    <li class="arrow"><a href="<?php $this->page('downloads') ?>"><?php $lang->downloads ?></a></li>
    <!--
    <li class="arrow"><a href=".html"></a></li>
    -->
</ul>
<ul class="rounded">
    <li class="arrow"><a href="<?php $this->page('profile') ?>"><?php $lang->profile ?></a></li>
    <li class="arrow"><a href="<?php $this->page('logout') ?>" id="logout"><?php $lang->logout ?></a></li>
</ul>
<script type="text/javascript">
    $('#logout').click(function(){
        if (!confirm('<?php $lang->confirm_logout ?>'))
        {
            return false;
        }
        return true;
    });
</script>
<?php endif ?>