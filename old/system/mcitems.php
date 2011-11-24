<?php
    require_once 'init.php';
    
    /** header **/
    header('Content-Type: text/javascript;charset=utf-8');
    $cacheLifetime = Config::instance('bukkitweb')->get('cacheLifetime', 0);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheLifetime) . ' GMT');
    header('Pragma: cache');
    header('Cache-Control: max-age=' . $cacheLifetime);
    /** /header **/

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
