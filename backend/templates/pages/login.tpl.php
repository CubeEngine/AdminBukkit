<?php $lang = Lang::instance('login') ?>
<form id="login_form" action="<?php $this->page('login') ?>" method="post" accept-charset="utf-8">
    <?php if (isset($errors) && count($errors)): ?>
    <div class="infobox">
        <h4><?php $lang->errors ?>:</h4>
        <div style="color:red">
            <?php echo implode("<br>", $errors) ?>
        </div>
    </div>
    <?php endif ?>
    <label for="login_user"><?php $lang->username ?></label>
    <input type="text" name="user" id="login_user" placeholder="<?php $lang->username ?>" value="<?php echo $user ?>" required>
    <label for="login_pass"><?php $lang->password ?></label>
    <input type="password" name="pass" id="login_pass" placeholder="<?php $lang->password ?>" required>

    <label for="login_lang"><?php $lang->language ?></label>
    <select name="lang" id="login_lang">
        <?php foreach ($langs as $code): ?>
        <option name="<?php echo $code ?>"><?php $lang->out('lang_' . $code) ?></option>
        <?php endforeach ?>
    </select>
    <label for="login_nocookies"><?php $lang->nocookies ?></label>
    <input type="checkbox" name="nocookies" id="login_nocookies" value="disable">
    <input type="submit" value="<?php $lang->login ?>">
</form>
