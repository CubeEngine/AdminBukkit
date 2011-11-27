<?php if ($messageCount): ?>
AdminBukkit.registerLanguage('<?php echo strtolower($cat) ?>',
{
<?php
    $i = 0;
    foreach ($messages as $source => $target)
    {
        ++$i;
        echo '    \'' . str_replace(array("\r\n", "\n", "\r"), '\n', addslashes($source))
           . '\': \'' . str_replace(array("\r\n", "\n", "\r"), '\n', addslashes($target))
           . '\'';
        if ($i < $messageCount)
        {
            echo ',';
        }
        echo "\n";
    }
?>});
<?php else: ?>
throw 'Message category not found!';
<?php endif ?>
