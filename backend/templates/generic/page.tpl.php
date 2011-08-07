<?php $lang = Lang::instance('generic') ?>
<div id="<?php echo $pageName ?>" data-role="page">
    <?php $this->subTemplate('toolbar') ?>
    <div data-role="content">
    <?php if (isset($_GET['msg'])): ?>
    <h2><?php $lang->message ?>:</h2>
    <ul>
        <li><?php echo htmlspecialchars(urldecode($_GET['msg'])) ?></li>
    </ul>
    <?php endif ?>
    <?php $this->subTemplate('content') ?>
    <?php if (isset($infoText)): ?>
    </div>
    <div data-role="footer">
        <?php echo $infoText ?>
    </div>
    <?php endif ?>
</div>