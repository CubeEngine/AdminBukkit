<?php $lang = Lang::instance('register') ?>
<form action="<?php $this->page('register') ?>" method="post" accept-charset="utf-8" id="register_form">
    <?php if (isset($errors)): ?>
    <div class="ui-body ui-body-e">
        <h4><?php $lang->errors ?>:</h4>
        <div style="color:red">
            <?php echo implode("<br>", $errors) ?>
        </div>
    </div>
    <?php endif ?>
    <h2><?php $lang->fillin ?></h2>
    <label for="register_user"><?php $lang->username ?></label>
    <input name="user" id="register_user" type="text" placeholder="<?php $lang->username ?>" value="<?php echo $user ?>" size="40" required>

    <label for="register_email"><?php $lang->email ?></label>
    <input name="email" id="register_email" type="email" placeholder="<?php $lang->exampleemail ?>" value="<?php echo $email ?>" required>

    <label for="register_pass"><?php $lang->password ?></label>
    <input name="pass" id="register_pass" type="password" placeholder="<?php $lang->password ?>" required>

    <label for="register_pass_repeat"><?php $lang->password_repeat ?></label>
    <input name="pass_repeat" id="register_pass_repeat" type="password" placeholder="<?php $lang->password_repeat ?>" required>

    <label for="register_serveraddr"><?php $lang->serveraddr ?></label>
    <input name="serveraddr" id="register_serveraddr" type="text" placeholder="<?php $lang->serveraddr ?>" value="<?php echo $serveraddr ?>" required>

    <label for="register_apiport"><?php $lang->apiport ?></label>
    <input name="apiport" id="register_apiport" type="number" placeholder="<?php $lang->apiport ?>" value="<?php echo $apiport ?>" size="5" required>
    
    <label for="register_apipass"><?php $lang->apipassword ?></label>
    <input name="apipass" id="register_apipass" type="text" placeholder="<?php $lang->apipassword ?>" value="<?php echo $apipass ?>" required>
    
    <input type="submit" value="<?php $lang->register ?>">
</form>
