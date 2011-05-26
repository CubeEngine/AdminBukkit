<?php $lang = Lang::instance('plugin') ?>
<ul class="rounded">
    <li><?php $lang->status ?>: <?php echo ($enabled ? $lang->active : $lang->inactive) ?></li>
    <li title="<?php echo $fullName ?>"><?php $lang->name ?>: <?php echo $pluginName ?></li>
    <li><?php $lang->version ?>: <?php echo $version ?></li>
    <?php if ($website !== null): ?>
    <li class="forward"><a href="<?php echo $website ?>" target="_blank"><?php $lang->website ?>: <?php echo $website ?></a></li>
    <?php endif ?>
    <?php if ($description !== null): ?>
    <li><?php $lang->description ?>:<br><?php echo $description ?></li>
    <?php endif ?>
    <?php if ($authors !== null): ?>
    <li class="contentSlide">
        <?php $lang->authors ?>:<br>
        <div>
        <?php foreach ($authors as $command): ?>
        &nbsp;&nbsp;- <?php echo $command ?><br>
        <?php endforeach ?>
        </div>
    </li>
    <?php endif ?>
    <?php if ($commands !== null): ?>
    <li class="contentSlide">
        <?php $lang->commands ?>:<br>
        <div>
        <?php foreach ($commands as $command => $infos): ?>
        &nbsp;&nbsp;- <?php echo $command ?><br>
        <?php endforeach ?>
        </div>
    </li>
    <?php endif ?>
    <?php if ($depend !== null): ?>
    <li class="contentSlide">
        <?php $lang->dependencies ?>:<br>
        <div>
        <?php foreach ($depend as $dependency): ?>
        &nbsp;&nbsp;- <?php echo $dependency ?><br>
        <?php endforeach ?>
        </div>
    </li>
    <?php endif ?>
    <?php
        $offset = strlen($dataFolder) - 30;
    ?>
    <li><?php $lang->datafolder ?>: <span title="<?php echo $dataFolder ?>"><?php echo '...' . substr($dataFolder, $offset) ?></span></li>
</ul>
<ul class="rounded">
    <?php if ($enabled): ?>
    <li><a href="#" id="plugin_disable"><?php $lang->disableplugin ?></a></li>
    <?php else: ?>
    <li><a href="#" id="plugin_enable"><?php $lang->enableplugin ?></a></li>
    <?php endif ?>
    <li><a href="#" id="plugin_reload"><?php $lang->reloadplugin ?></a></li>
</ul>
<script type="text/javascript">
    var plugin = '<?php echo $pluginName ?>';
    
    $('#plugin_disable').click(function(){
        alert(genericLang.function_disabled);
        return false;
        
        if (confirm('<?php $lang->confirmdisable ?>'))
        {
            var request = new ApiRequest('plugin', 'disable');
            request.onSuccess(function(){
                alert('<?php $lang->disablesuccess ?>');
            });
            request.onFailure(function(code){
                switch (code)
                {
                    case 1:
                    case 2:
                        alert('<?php $lang->pluginunavailable ?>');
                        break;
                }
            });
            request.execute({plugin: plugin});
        }
        return false;
    });
    
    $('#plugin_enable').click(function(){
        alert(genericLang.function_disabled);
        return false;
        
        if (confirm('<?php $lang->confirmenable ?>'))
        {
            var request = new ApiRequest('plugin', 'enable');
            request.onSuccess(function(){
                alert('<?php $lang->enabledsuccess ?>');
            });
            request.onFailure(function(code){
                switch (code)
                {
                    case 1:
                    case 2:
                        alert('<?php $lang->pluginunavailable ?>');
                        break;
                }
            });
            request.execute({plugin: plugin});
        }
        return false;
    });
    
    $('#plugin_reload').click(function(){
        alert(genericLang.function_disabled);
        return false;
        
        if (confirm('<?php $lang->confirmreload ?>'))
        {
            var request = new ApiRequest('plugin', 'reload');
            request.onSuccess(function(){
                alert('<?php $lang->reloadsuccess ?>');
            });
            request.onFailure(function(code){
                switch (code)
                {
                    case 1:
                    case 2:
                        alert('<?php $lang->pluginunavailable ?>');
                        break;
                }
            });
            request.execute({plugin: plugin});
        }
        return false;
    });
    
    $('#plugin .contentSlide').click(function(e){
        $(e.target).children('div').toggle('fast');
    });
</script>