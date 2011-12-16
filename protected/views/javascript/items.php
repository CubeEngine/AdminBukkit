var items = {
<?php
    if (($handle = @fopen(dirname(Yii::app()->basePath) . '/res/items.csv', 'rb')) !== false)
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
?>

}
