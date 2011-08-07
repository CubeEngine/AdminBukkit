<div data-role="header">
    <?php if (isset($backText)): ?>
        <?php if (isset($backTarget)): ?>
        <a data-rel="back" href="<?php echo $backTarget ?>"><?php echo $backText ?></a>
        <?php else: ?>
        <a data-rel="back"><?php echo $backText ?></a>
        <?php endif ?>
    <?php endif ?>

    <h1><?php echo $pageTitle ?></h1>

    <?php if (isset($btnTarget, $btnText)): ?>
        <a href="<?php echo $btnTarget ?>"><?php echo $btnText ?></a>
    <?php endif ?>
</div>
