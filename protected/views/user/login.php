<form action="<?php $this->createUrl('user/login') ?>" method="POST" accept-charset="utf-8" data-ajax="false">
    <label for="login_id"><?php echo Yii::t('login', 'Your Login ID') ?></label>
    <input type="text" id="login_id" name="LoginForm[id]" required="" value="<?php echo $model->id ?>" />

    <label for="login_password"><?php echo Yii::t('login', 'Your Password') ?></label>
    <input type="password" id="login_password" name="LoginForm[password]" required="" />

    <label for="login_nocookies"><?php echo Yii::t('login', 'Disable Cookies?') ?></label>
    <input type="checkbox" id="login_nocookies" name="LoginForm[nocookies]" />

    <input type="submit" value="<?php echo Yii::t('login', 'Login') ?>" />
</form>
