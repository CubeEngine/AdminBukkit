<?php
    $lang = Lang::instance('operatorlist');
    $page = new Page('operatorlist', $lang['title'], true);
    $page->setContent(new Template('pages/popups/operatorlist'));

    $design->setContentView($page);
?>
