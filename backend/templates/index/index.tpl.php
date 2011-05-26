<?php
    $lang = Lang::instance('generic');
?><!DOCTYPE html>
<html>
    <head>
        <title>Bukkit Web Admin</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="apple-touch-icon" href="gfx/icon.ico">
        <link rel="apple-touch-startup-image" href="gfx/startup.png">
        <style type="text/css" media="screen">@import "css/jqtouch.css";</style>
        <style type="text/css" media="screen">@import "themes/<?php echo $theme ?>/theme.css";</style>
        <style type="text/css" media="screen">@import "css/main.css";</style>
        <script type="text/javascript">
            var SESS_APPEND = <?php echo (Request::session('cookies') ? 'false' : 'true') ?>;
            var SESS_NAME = '<?php echo session_name() ?>';
            var SESS_ID = '<?php echo session_id() ?>';
            var SESS_QUERY = SESS_NAME + '=' + SESS_ID;
        </script>
        <script type="text/javascript" src="backend/javascriptlang.php?file=generic" charset="utf-8"></script>
        <script type="text/javascript" src="js/jquery.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="js/main.js" charset="utf-8"></script>
        <script type="text/javascript" src="js/apirequest.js" charset="utf-8"></script>
        <script type="text/javascript" src="js/wkshake.js" charset="utf-8"></script>
    </head>
    <body>
        <div id="jqt">
            <?php $this->displaySubTemplate('page') ?>
        </div>
        <div id="progress"><?php $lang->progress ?></div>
    </body>
</html>