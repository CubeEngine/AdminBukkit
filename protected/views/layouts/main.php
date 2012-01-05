<!DOCTYPE html>
<html>
    <head>
        <title><?php echo CHtml::encode(Yii::app()->name); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/res/jquery/jquery.mobile.css">
        <!--<link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/latest/jquery.mobile.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/res/css/main.css">
        <link rel="shortcut icon" type="image/png" href="<?php echo Yii::app()->request->baseUrl ?>/gfx/icons/favicon.png">
        <link rel="apple-touch-icon-precomposed" media="screen and (resolution: 163dpi)" href="<?php echo Yii::app()->request->baseUrl ?>/gfx/icons/iphone.png">
        <link rel="apple-touch-icon-precomposed" media="screen and (resolution: 132dpi)" href="<?php echo Yii::app()->request->baseUrl ?>/gfx/icons/ipad.png">
        <link rel="apple-touch-icon-precomposed" media="screen and (resolution: 326dpi)" href="<?php echo Yii::app()->request->baseUrl ?>/gfx/icons/iphone4.png">
        <link rel="apple-touch-startup-image" media="screen and (resolution: 163dpi)" href="<?php echo Yii::app()->request->baseUrl ?>/gfx/startup/iphone.png">
        <link rel="apple-touch-startup-image" media="screen and (resolution: 132dpi)" href="<?php echo Yii::app()->request->baseUrl ?>/gfx/startup/ipad.png">
        <link rel="apple-touch-startup-image" media="screen and (resolution: 326dpi)" href="<?php echo Yii::app()->request->baseUrl ?>/gfx/startup/iphone4.png">
        <script type="text/javascript">
            var BASE_PATH = '<?php echo Yii::app()->request->baseUrl ?>';
        </script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/res/jquery/jquery.js" charset="utf-8"></script>
        <!--<script type="text/javascript" src="http://code.jquery.com/mobile/latest/jquery.mobile.js" charset="utf-8"></script>-->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/res/jquery/jquery.mobile.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/res/js/AdminBukkit.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->createUrl('javascript/translation', array('cat' => 'generic')) ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/res/js/ApiRequest.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/res/js/main.js" charset="utf-8"></script>
    </head>
    <body>
        <div id="container">
            <?php echo $content; ?>
        </div>
    </body>
</html>