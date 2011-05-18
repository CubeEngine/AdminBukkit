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
        <?php foreach ($authors as $command): ?>
        &nbsp;&nbsp;- <?php echo $command ?><br>
        <?php endforeach ?>
    </li>
    <?php endif ?>
    <?php if ($commands !== null): ?>
    <li class="contentSlide">
        <?php $lang->commands ?>:<br>
        <?php foreach ($commands as $command => $infos): ?>
        &nbsp;&nbsp;- <?php echo $command ?><br>
        <?php endforeach ?>
    </li>
    <?php endif ?>
    <?php if ($depend !== null): ?>
    <li class="contentSlide">
        <?php $lang->dependencies ?>:<br>
        <?php foreach ($depend as $dependency): ?>
        &nbsp;&nbsp;- <?php echo $dependency ?><br>
        <?php endforeach ?>
    </li>
    <?php endif ?>
    <?php
        $offset = strlen($dataFolder) - 40;
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
    $('#plugin_disable').click(function(){
        alert(genericLang.function_disabled);
        return false;
        
        if (confirm('<?php $lang->confirmdisable ?>'))
        {
            apiCall('plugin', '', function(){
                alert('<?php $lang->disablesuccess ?>');
            })
        }
        return false;
    });
    
    $('#plugin_enable').click(function(){
        alert(genericLang.function_disabled);
        return false;
        
        if (confirm('<?php $lang->confirmenable ?>'))
        {
            apiCall('plugin', '', function(){
                alert('<?php $lang->enabledsuccess ?>');
            })
        }
        return false;
    });
    
    $('#plugin_reload').click(function(){
        alert(genericLang.function_disabled);
        return false;
        
        if (confirm('<?php $lang->confirmreload ?>'))
        {
            apiCall('plugin', '', function(){
                alert('<?php $lang->reloadsuccess ?>');
            })
        }
        return false;
    });
</script>