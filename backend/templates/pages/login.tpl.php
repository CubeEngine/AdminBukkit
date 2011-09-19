<?php $lang = Lang::instance('login') ?>
<form id="login_form" action="<?php $this->page('login') ?>" method="post" accept-charset="utf-8" data-ajax="false">
    <label for="login_user"><?php $lang->username ?></label>
    <input type="text" name="user" id="login_user" placeholder="<?php $lang->username ?>" value="<?php echo $user ?>" required>
    <label for="login_pass"><?php $lang->password ?></label>
    <input type="password" name="pass" id="login_pass" placeholder="<?php $lang->password ?>" required value="">

    <label for="login_lang"><?php $lang->language ?></label>
    <select name="lang" id="login_lang">
        <?php foreach ($langs as $code): ?>
        <option name="<?php echo $code ?>"><?php $lang->out('lang_' . $code) ?></option>
        <?php endforeach ?>
    </select>
    <input type="submit" value="<?php $lang->login ?>">
</form>
