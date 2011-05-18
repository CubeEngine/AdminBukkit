<div class="toolbar">
    <h1><?php echo $pageTitle ?></h1>
    <?php if (isset($backText)): ?>
        <?php if (isset($backTarget)): ?>
        <a href="<?php echo $backTarget ?>" class="back"><?php echo $backText ?></a>
        <?php else: ?>
        <a class="back"><?php echo $backText ?></a>
        <?php endif ?>
    <?php endif ?>
    
    <?php if (isset($btnTarget, $btnText)): ?>
        <a href="<?php echo $btnTarget ?>" class="button"><?php echo $btnText ?></a>
    <?php endif ?>
</div>
