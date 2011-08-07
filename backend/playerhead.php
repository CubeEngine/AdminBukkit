<?php
    require_once 'init.php';

    define('HEAD_ADDRESS', 'http://s3.amazonaws.com/MinecraftSkins/');
    define('HEAD_DEFAULT', RESOURCE_PATH . DS . 'gfx' . DS . 'char.png');

    $targetSize = 24;
    $sizeParam = trim(Request::get('size', 24));
    if (is_numeric($sizeParam))
    {
        $targetSize = abs(intval($sizeParam));
    }
    $player = trim(Request::get('player', ''));
    $url = HEAD_ADDRESS . $player . '.png';

    if (empty($player) || @getimagesize($url) === false)
    { // default
        $img = imagecreatefrompng(HEAD_DEFAULT);
    }
    else
    { // custom
        $img = imagecreatefrompng($url);
    }
    $new = imagecreatetruecolor($targetSize, $targetSize);
    imagealphablending($new, false);
    imagesavealpha($new, true);
    imagecopyresampled($new, $img, 0, 0, 8, 8, $targetSize, $targetSize, 8, 8);

    header('Content-Type: image/png');
    imagepng($new);
?>
