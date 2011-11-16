<?php $lang = Lang::instance('editprofile') ?>
<?php $registerLang = Lang::instance('register') ?>
<form action="<?php $this->page('editprofile') ?>" method="post" accept-charset="utf-8" data-ajax="false">
    <h2><?php $lang->changeinfos ?>:</h2>
    
    <label for="editprofile_user"><?php $registerLang->username ?>:</label>
    <input name="user" id="editprofile_user" type="text" placeholder="<?php $registerLang->username ?>" autofocus value="<?php echo $user ?>" size="40">
    
    <label for="editprofile_email"><?php $registerLang->email ?>:</label>
    <input name="email" id="editprofile_email" type="email" placeholder="<?php $registerLang->exampleemail ?>" value="<?php echo $email ?>">
    
    <label for="editprofile_pass"><?php $registerLang->password ?>:</label>
    <input name="pass" id="editprofile_pass" type="password" placeholder="<?php $registerLang->password ?>">
    
    <label for="editprofile_pass_repeat"><?php $registerLang->password_repeat ?>:</label>
    <input name="pass_repeat" id="editprofile_pass_repeat" type="password" placeholder="<?php $registerLang->password_repeat ?>">

    <input type="submit" value="<?php $lang->change ?>">
</form>