<?php $lang = Lang::instance('addworld') ?>
<form id="addworld_form" action="" method="post">
    <label for="addworld_name"><?php $lang->name ?>:</label>
    <input type="text" name="name" id="addworld_name" placeholder="<?php $lang->name ?>">
    <label for="addworld_environment"><?php $lang->environment ?>:</label>
    <select name="environment" id="addworld_environment">
        <option value="0"><?php $lang->env_normal ?></option>
        <option value="-1"><?php $lang->env_nether ?></option>
        <option value="1"><?php $lang->env_skylands ?></option>
    </select>
    <label for="addworld_seed"><?php $lang->seed ?>:</label>
    <input type="text" name="seed" id="addworld_seed" placeholder="<?php $lang->seed ?>">
    <label for="addworld_generator"><?php $lang->generator ?>:</label>
    <input type="text" name="generator" id="addworld_generator" placeholder="<?php $lang->generator ?>">

    <input type="submit" value="<?php $lang->done ?>">
</form>
<script type="text/javascript" src="<?php echo Router::instance()->getBasePath() ?>backend/javascriptlang.php?file=worldutils"></script>
<script type="text/javascript" src="<?php $this->res('js/worldutils.js') ?>"></script>
<script type="text/javascript">
$('#addworld_form').bind('submit', function(){
    world_create(
        $('#addworld_name').val(),
        $('#addworld_seed').val(),
        $('#addworld_environment').val(),
        $('#addworld_generator').val(),
        function(){
            $('#addworld').dialog('close');
        }
    );
    return false;
});
</script>