<?php
    header('Content-Type: text/javascript;charset=utf-8');
    require_once 'init.php';
    echo "var items = {\n";

    if (($handle = @fopen(RESOURCE_PATH . DS . 'items.csv', 'rb')) !== false)
    {
        $i = 0;
        while (($item = @fgetcsv($handle)))
        {
            if (count($item) === 3 && $item[0][0] !== '#')
            {
                if ($i > 0)
                {
                    echo ",\n";
                }
                echo "    {$item[0]}: [{$item[1]}, {$item[2]}]";
                ++$i;
            }
        }
        @fclose($handle);
    }

    echo "\n}\n"
?>
