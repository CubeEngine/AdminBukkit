<?php
    $lang = Lang::instance('worldpopup');
    $world = trim(Request::get('world'));
    if ($world === '')
    {
        Router::instance()->redirectToPage('worlds', $lang['noworld']);
    }
    $page = new Page('worldpopup', $lang['playerinfos'], true);
    $page->assign('world', $world);
    $page->setContent(new Template('pages/worldpopup'));

    $design->setContentView($page);
?>
