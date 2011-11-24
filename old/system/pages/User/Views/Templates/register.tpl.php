<?php $lang = Lang::instance('register') ?>
<form action="<?php $this->page('register') ?>" method="post" accept-charset="utf-8" data-ajax="false">
    <h2><?php $lang->fillin ?></h2>
    <label for="register_user"><?php $lang->username ?></label>
    <input name="user" id="register_user" type="text" placeholder="<?php $lang->username ?>" value="<?php echo $user ?>" size="40" required>

    <label for="register_email"><?php $lang->email ?></label>
    <input name="email" id="register_email" type="email" placeholder="<?php $lang->exampleemail ?>" value="<?php echo $email ?>" required>

    <label for="register_pass"><?php $lang->password ?></label>
    <input name="pass" id="register_pass" type="password" placeholder="<?php $lang->password ?>" required>

    <label for="register_pass_repeat"><?php $lang->password_repeat ?></label>
    <input name="pass_repeat" id="register_pass_repeat" type="password" placeholder="<?php $lang->password_repeat ?>" required>
    
    <input type="submit" value="<?php $lang->register ?>">
</form>
