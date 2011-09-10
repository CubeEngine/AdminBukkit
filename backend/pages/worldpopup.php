<?php
    $lang = Lang::instance('worldpopup');
    $world = trim(Request::get('world'));
    if ($world === '')
    {
        Router::instance()->redirectToPage('worlds', $lang['noworld']);
    }
    $page = new Page('worldpopup', true);
    $page->assign('world', $world);
    $toolbar = new Toolbar($lang['playerinfos']);
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/worldpopup'));

    $design->setContentView($page);
?>
