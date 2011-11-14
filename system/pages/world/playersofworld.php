<?php
    $lang = Lang::instance('players');
    $page = new Page('playersofworld', $lang['playerlist'], true);
    $world = Request::get('world', '');
    if (!empty($world))
    {
        $page->assign('world', $world);
    }
    $page->setBack(Lang::instance('generic')->get('btn_back'))
         ->setButton($lang['refresh'], '#')
         ->setContent(new Template('pages/players'))
         ->setInfo($lang['pageinfo']);

    $design->setContentView($page);
?>
