<?php $lang = Lang::instance('editprofile') ?>
<?php $registerLang = Lang::instance('register') ?>
<form action="editprofile.html" method="post" accept-charset="utf-8" id="editprofile_form">
    <?php if (isset($errors)): ?>
    <h2><?php $registerLang->errors ?>:</h2>
    <ul class="rounded">
        <li style="color:red"><?php echo implode("<br>", $errors) ?></li>
    </ul>
    <?php endif ?>
    <h2><?php $lang->changeinfos ?>:</h2>
    <ul class="rounded">
        <li><input name="user" id="user" type="text" placeholder="<?php $registerLang->username ?>" autofocus value="<?php echo $user ?>" size="40"></li>
        <li><input name="email" id="email" type="email" placeholder="<?php $registerLang->email ?>" value="<?php echo $email ?>"></li>
        <li><input name="pass" id="pass" type="password" placeholder="<?php $registerLang->password ?>"></li>
        <li><input name="pass_repeat" id="pass_repeat" type="password" placeholder="<?php $registerLang->password_repeat ?>"></li>
        <li><input name="serveraddr" id="serveraddr" type="text" placeholder="<?php $registerLang->serveraddr ?>" value="<?php echo $serveraddr ?>"></li>
        <li><input name="apiport" id="apiport" type="text" placeholder="<?php $registerLang->apipport ?>" value="<?php echo $apiport ?>" size="5"></li>
        <li><input name="apipass" id="apipass" type="text" placeholder="<?php $registerLang->apipassword ?>" value="<?php echo $apipass ?>"></li>
    </ul>
    <ul style="background:none;border:none">
        <li><a href="#" id="editprofile_submit" class="whiteButton submit"><?php $lang->change ?></a></li>
    </ul>
    <script type="text/javascript">
        prepareForm('#editprofile_form');
    </script>
</form>
