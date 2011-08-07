<div data-role="header">
    <?php if (isset($backText)): ?>
        <?php if (isset($backTarget)): ?>
        <a href="<?php echo $backTarget ?>" class="back"><?php echo $backText ?></a>
        <?php else: ?>
        <a class="back"><?php echo $backText ?></a>
        <?php endif ?>
    <?php endif ?>

    <h1><?php echo $pageTitle ?></h1>

    <?php if (isset($btnTarget, $btnText)): ?>
        <a href="<?php echo $btnTarget ?>"><?php echo $btnText ?></a>
    <?php endif ?>
</div>
