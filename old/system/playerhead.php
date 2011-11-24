<?php
    require_once 'init.php';

    /** header **/
    header('Content-Type: image/png');
    $cacheLifetime = Config::instance('bukkitweb')->get('cacheLifetime', 0);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheLifetime) . ' GMT');
    header('Pragma: cache');
    header('Cache-Control: max-age=' . $cacheLifetime);
    /** /header **/

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

    imagepng($new);
?>
