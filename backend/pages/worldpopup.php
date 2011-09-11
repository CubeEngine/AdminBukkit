<?php
    $lang = Lang::instance('worldpopup');
    $world = trim(Request::get('world'));
    if ($world === '')
    {
        Router::instance()->redirectToPage('worlds', $lang['noworld']);
    }
    $page = new Page('worldpopup', $world, true);
    $page->assign('world', $world)
         ->setContent(new Template('pages/worldpopup'));

    $design->setContentView($page);
?>
