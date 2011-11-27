<form action="<?php echo $this->createUrl('server/add') ?>" method="POST" accept-charset="utf-8" data-ajax="false">
    <div data-role="fieldcontain">
        <label for="server_alias"><?php echo Yii::t('server', 'Name') ?>:</label>
        <input type="text" id="server_alias" name="ServerForm[alias]" value="<?php echo $model->alias ?>" size="30" />
    </div>

    <div data-role="fieldcontain">
        <label for="server_host"><?php echo Yii::t('server', 'Host') ?>:</label>
        <input type="text" id="server_host" name="ServerForm[host]" value="<?php echo $model->host ?>" size="100" />
    </div>

    <div data-role="fieldcontain">
        <label for="server_port"><?php echo Yii::t('server', 'Port') ?>:</label>
        <input type="number" id="server_port" name="ServerForm[port]" value="<?php echo $model->port ?>" size="5" />
    </div>

    <div data-role="fieldcontain">
        <label for="server_authkey"><?php echo Yii::t('server', 'Authkey') ?>:</label>
        <input type="text" id="server_authkey" name="ServerForm[authkey]" value="<?php echo $model->authkey ?>" size="40" />
    </div>

    <input type="submit" value="<?php echo Yii::t('server', 'Add the server!') ?>" />
</form>