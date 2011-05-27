<?php $lang = Lang::instance('home') ?>
<h2><?php $lang->menu ?>:</h2>
<?php if (!User::loggedIn()): ?>
<ul class="rounded">
    <li class="arrow"><a href="register.html"><?php $lang->registration ?></a></li>
    <li class="arrow"><a href="login.html"><?php $lang->login ?></a></li>
    <li class="arrow"><a href="stats.html"><?php $lang->stats ?></a></li>
    <li class="arrow"><a href="downloads.html"><?php $lang->downloads ?></a></li>
</ul>
<?php else: ?>
<ul class="rounded">
    <li class="arrow"><a href="server.html"><?php $lang->serverinfo ?></a></li>
    <li class="arrow"><a href="players.html"><?php $lang->manplayers ?></a></li>
    <li class="arrow"><a href="worlds.html"><?php $lang->manworlds ?></a></li>
    <li class="arrow"><a href="plugins.html"><?php $lang->manplugins ?></a></li>
    <li class="arrow"><a href="stats.html"><?php $lang->stats ?></a></li>
    <li class="arrow"><a href="downloads.html"><?php $lang->downloads ?></a></li>
    <!--
    <li class="arrow"><a href=".html"></a></li>
    -->
</ul>
<ul class="rounded">
    <li class="arrow"><a href="profile.html"><?php $lang->profile ?></a></li>
    <li class="arrow"><a href="logout.html" id="logout"><?php $lang->logout ?></a></li>
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