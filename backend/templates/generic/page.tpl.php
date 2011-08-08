<?php $lang = Lang::instance('generic') ?>
<div id="<?php echo $pageName ?>" data-role="page">
    <?php $this->subTemplate('toolbar') ?>
    <div data-role="content">
        <?php if (isset($_GET['msg'])): ?>
        <div class="ui-body ui-body-e">
            <h4 style="margin:.5em 0"><?php $lang->message ?></h4>
            <?php echo htmlspecialchars(urldecode($_GET['msg'])) ?>
        </div>
        <?php endif ?>
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