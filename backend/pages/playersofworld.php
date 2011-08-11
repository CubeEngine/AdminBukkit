<?php
    $lang = Lang::instance('players');
    $page = new Page('playersofworld', true);
    $world = Request::get('world', '');
    if (!empty($world))
    {
        $page->assign('world', $world);
    }
    $toolbar = new Toolbar($lang['playerlist']);
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    $toolbar->setButton($lang['refresh'], '#');
    $page->addSubtemplate('toolbar', $toolbar);
    $page->setContent(new Template('pages/players'));
    $page->setInfo($lang['pageinfo']);

    $design->setContentView($page);
?>
