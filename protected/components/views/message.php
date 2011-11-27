<div class="ui-body ui-body-e">
    <h4 style="margin:.5em 0"><?php echo $title ?></h4>
    <?php if (count($messages) > 1): ?>
        <ul>
        <?php foreach ($messages as $message): ?>
            <li><?php echo $message ?></li>
        <?php endforeach ?>
        </ul>
    <?php elseif (count($messages)): ?>
        <?php echo $messages[0] ?>
    <?php endif ?>
</div>