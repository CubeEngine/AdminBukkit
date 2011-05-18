<?php
    $lang = Lang::instance('register');
?><form action="register.html" method="post" accept-charset="utf-8" id="register_form">    <?php if (isset($errors)): ?>
    <h2><?php $lang->errors ?>:</h2>
    <ul class="rounded">
        <li style="color:red"><?php echo implode("<br>", $errors) ?></li>
    </ul>
    <?php endif ?>
    <h2><?php $lang->fillin ?></h2>
    <ul class="rounded">
        <li><input name="user" id="user" type="text" placeholder="<?php $lang->username ?>" value="<?php echo $user ?>" size="40"></li>
        <li><input name="email" id="email" type="email" placeholder="<?php $lang->email ?>" value="<?php echo $email ?>"></li>
        <li><input name="pass" id="pass" type="password" placeholder="<?php $lang->password ?>"></li>
        <li><input name="pass_repeat" id="pass_repeat" type="password" placeholder="<?php $lang->password_repeat ?>"></li>
        <li><input name="serveraddr" id="serveraddr" type="text" placeholder="<?php $lang->serveraddr ?>" value="<?php echo $serveraddr ?>"></li>
        <li><input name="apiport" id="apiport" type="number" placeholder="<?php $lang->apiport ?>" value="<?php echo $apiport ?>" size="5"></li>
        <li><input name="apipass" id="apipass" type="text" placeholder="<?php $lang->apipassword ?>" value="<?php echo $apipass ?>"></li>
    </ul>
    <ul style="background:none;border:none">
        <li><a href="#" class="whiteButton submit"><?php $lang->register ?></a></li>
    </ul>
    <script type="text/javascript">
        prepareForm('#register_form');
    </script>
</form>
