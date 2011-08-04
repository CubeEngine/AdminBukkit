<?php
    $lang = Lang::instance('generic');
?><!DOCTYPE html>
<html>
    <head>
        <title>AdminBukkit</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="shortcut icon" type="image/png" href="<?php $this->res('gfx/favicon.png') ?>">
        <link rel="apple-touch-icon-precomposed" media="screen and (resolution: 163dpi)" href="<?php $this->res('gfx/icon-iphone.png') ?>">
        <link rel="apple-touch-icon-precomposed" media="screen and (resolution: 132dpi)" href="<?php $this->res('gfx/icon-ipad.png') ?>">
        <link rel="apple-touch-icon-precomposed" media="screen and (resolution: 326dpi)" href="<?php $this->res('gfx/icon-iphone4.png') ?>">
        <link rel="apple-touch-startup-image" media="screen and (resolution: 163dpi)" href="<?php $this->res('gfx/startup-iphone.png') ?>">
        <link rel="apple-touch-startup-image" media="screen and (resolution: 132dpi)" href="<?php $this->res('gfx/startup-ipad.png') ?>">
        <link rel="apple-touch-startup-image" media="screen and (resolution: 326dpi)" href="<?php $this->res('gfx/startup-iphone4.png') ?>">
        <style type="text/css" media="screen">@import "<?php $this->res('css/jqtouch.css') ?>";</style>
        <style type="text/css" media="screen">@import "<?php $this->res("themes/$theme/theme.css") ?>";</style>
        <style type="text/css" media="screen">@import "<?php $this->res('css/main.css') ?>";</style>
        <script type="text/javascript">
            var SESS_APPEND = <?php echo (Request::session('cookies') ? 'false' : 'true') ?>;
            var SESS_NAME = '<?php echo session_name() ?>';
            var SESS_ID = '<?php echo session_id() ?>';
            var SESS_QUERY = SESS_NAME + '=' + SESS_ID;
            var BASE_PATH = '<?php echo $basePath ?>';
        </script>
        <script type="text/javascript" src="<?php echo $basePath ?>/backend/javascriptlang.php?file=generic" charset="utf-8"></script>
        <script type="text/javascript" src="<?php $this->res('js/jquery.min.js') ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php $this->res('js/wkshake.js') ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php $this->res('js/apirequest.js') ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php $this->res('js/main.js') ?>" charset="utf-8"></script>
    </head>
    <body>
        <div id="jqt">
            <?php $this->displaySubTemplate('page') ?>
        </div>
        <div id="progress"><?php $lang->progress ?></div>
    </body>
</html>