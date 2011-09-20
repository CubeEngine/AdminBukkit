<?php
    require_once 'init.php';

    /** header **/
    header('Content-Type: text/javascript;charset=utf-8');
    $cacheLifetime = Config::instance('bukkitweb')->get('cacheLifetime', 0);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheLifetime) . ' GMT');
    header('Pragma: cache');
    header('Cache-Control: max-age=' . $cacheLifetime);
    /** /header **/

    $file = strtolower(Request::get('file', 'generic'));
    $classname = ucfirst($file) . 'Lang';
    echo "function $classname() {\n";
    try
    {
        $lang = Lang::instance($file)->getMap();
        foreach ($lang as $index => $value)
        {
            echo "    this.$index = \"" . str_replace("\n", '\n', addslashes($value)) . "\";\n";
        }
    }
    catch (Exception $e)
    {}
    echo "}\n";
?>
