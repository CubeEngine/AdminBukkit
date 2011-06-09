<?php
    require_once 'init.php';

    define('HEAD_ADDRESS', 'http://s3.amazonaws.com/MinecraftSkins/');
    define('HEAD_SIZE', 24);
    define('HEAD_DEFAULT', BACKEND_PATH . DS . '../gfx/char.png');
    
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
    $new = imagecreatetruecolor(HEAD_SIZE, HEAD_SIZE);
    imagealphablending($new, false);
    imagesavealpha($new, true);
    imagecopyresampled($new, $img, 0, 0, 8, 8, HEAD_SIZE, HEAD_SIZE, 8, 8);

    header('Content-Type: image/png');
    imagepng($new);
?>
