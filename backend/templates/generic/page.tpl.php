<?php $lang = Lang::instance('generic') ?>
<div id="<?php echo $pageName ?>" data-role="page" data-title="AdminBukkit - <?php echo $pageTitle ?>" data-theme="a">
    <div data-role="header">
        <?php if (isset($backText)): ?>
            <?php if (isset($backTarget)): ?>
            <a data-rel="back" data-icon="back" id="<?php echo $pageName ?>_toolbar_back" href="<?php echo $backTarget ?>"><?php echo $backText ?></a>
            <?php else: ?>
            <a data-rel="back" data-icon="back" id="<?php echo $pageName ?>_toolbar_back"><?php echo $backText ?></a>
            <?php endif ?>
        <?php endif ?>

        <h1><?php echo $pageTitle ?></h1>

        <?php if (isset($btnTarget, $btnText)): ?>
            <a href="<?php echo $btnTarget ?>" id="<?php echo $pageName ?>_toolbar_button"><?php echo $btnText ?></a>
        <?php endif ?>
    </div>
    <?php if (isset($message)): ?>
    <div class="ui-body ui-body-e">
        <h4 style="margin:.5em 0"><?php $lang->message ?></h4>
        <?php echo $message ?>
    </div>
    <?php endif ?>
    <div data-role="content" data-theme="c">
        <div>
            <?php $this->subTemplate('content') ?>
        </div>
    </div>
    <?php if (isset($infoText)): ?>
    <div data-role="footer">
        <?php echo $infoText ?>
    </div>
    <?php endif ?>
</div>