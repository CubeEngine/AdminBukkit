<?php
    header('Content-Type: text/javascript;charset=utf-8');
    require_once 'init.php';
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
