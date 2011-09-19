<?php
    $lang = Lang::instance('operatorlist');
    $page = new Page('operatorlist', $lang['title'], true);
    $page->setContent(new Template('pages/popups/operatorlist'));

    $page->setButton($lang['addop'], '#');

    $design->setContentView($page);
?>
