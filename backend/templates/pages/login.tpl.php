<?php $lang = Lang::instance('login') ?>
<form id="login_form" action="login.html" method="post" accept-charset="utf-8">
    <?php if (isset($errors)): ?>
    <h2><?php $lang->errors ?></h2>
    <ul class="rounded">
        <li style="color:red"><?php echo implode("<br>", $errors) ?></li>
    </ul>
    <?php endif ?>
    <h2><?php $lang->enterlogin ?>:</h2>
    <ul class="edit rounded">
        <li><input type="text" name="user" placeholder="<?php $lang->username ?>" value="<?php echo $user ?>" id="host"></li>
        <li><input type="password" name="pass" placeholder="<?php $lang->password ?>" id="pass"></li>
        <li>
            <select name="lang">
                <?php foreach ($langs as $code): ?>
                <option name="<?php echo $code ?>"><?php $lang->out('lang_' . $code) ?></option>
                <?php endforeach ?>
            </select>
        </li>
        <li id="login_cookies"><input type="checkbox" name="nocookies" value="disable"> <span><?php $lang->nocookies ?></span></li>
    </ul>
    <ul style="background:none;border:none">
        <li><a href="#" class="whiteButton submit"><?php $lang->login ?></a></li>
    </ul>
    <script type="text/javascript">
        prepareForm('#login_form', true);
        $('#login_cookies span').click(function(){
            var checkBox = $('#login_cookies input[type=checkbox]');
            if (checkBox.attr('checked'))
            {
                checkBox.removeAttr('checked');
            }
            else
            {
                checkBox.attr('checked', true);
            }
        });
    </script>
</form>
