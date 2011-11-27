<form action="<?php $this->createUrl('register') ?>" method="post" accept-charset="utf-8" data-ajax="false">
    <h2><?php echo Yii::t('register', 'Fill in the form:') ?></h2>
    <label for="register_username"><?php echo Yii::t('register', 'Username') ?></label>
    <input type="text" name="RegisterForm[username]" id="register_username" placeholder="<?php echo Yii::t('register', 'Username') ?>" value="<?php echo $model->username ?>" size="40" required="" />

    <label for="register_email"><?php echo Yii::t('register', 'Email addess') ?></label>
    <input type="email" name="RegisterForm[email]" id="register_email" placeholder="<?php echo Yii::t('register', 'example@email.com') ?>" value="<?php echo $model->email ?>" size="100" required="" />

    <label for="register_password"><?php echo Yii::t('register', 'Password') ?></label>
    <input type="password" name="RegisterForm[password]" id="register_password" placeholder="<?php echo Yii::t('register', 'Password') ?>" required="" />

    <label for="register_password_repeat"><?php echo Yii::t('register', 'Repeat the password') ?></label>
    <input name="RegisterForm[password_repeat]" id="register_password_repeat" type="password" placeholder="<?php echo Yii::t('register', 'Repeat the password') ?>" required="" />

    <input type="submit" value="<?php echo Yii::t('register', 'Submit the registration.') ?>" />
</form>
