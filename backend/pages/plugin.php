<?php
    if (!isset($_GET['plugin']) || trim($_GET['plugin']) === '')
    {
        Router::redirectToPage('plugins');
    }
    $plugin = trim($_GET['plugin']);
    $page = new Page('plugin', true);
    $toolbar = new Toolbar('Infos');
    $toolbar->setBack(Lang::instance('generic')->get('btn_back'));
    //$toolbar->setButton($text, $target);
    $page->addSubtemplate('toolbar', $toolbar);
    $template = new Template('pages/plugin');

    $api = new ApiBukkit($_SESSION['user']->getServerAddress(), $_SESSION['user']->getApiPort(), $_SESSION['user']->getApiPassword());
    $response = $api->request('plugin', 'info', array(
        'format' => 'json',
        'plugin' => $plugin
    ));
    if ($response->getStatus() > 204)
    {
        $error = explode(',', $response->getBody());
        if ($error[0] == '3')
        {
            $err = $lang['pluginunavailable'];
        }
        else
        {
            $err = $lang['failedtoload'];
        }
        Router::redirectToPage('plugins', $err);
    }
    $data = json_decode($response->getBody());
    if ($data === null)
    {
        Router::redirectToPage('plugins', 'Konnte keine Informationen zum Plugin "' . $plugin . '" abrufen');
    }
    $template->assign('pluginName', $data->name);
    $template->assign('fullName', $data->fullName);
    $template->assign('dataFolder', $data->dataFolder);
    $template->assign('version', $data->version);
    $template->assign('description', $data->description);
    $template->assign('website', $data->website);
    $template->assign('authors', $data->authors);
    $template->assign('commands', $data->commands);
    $template->assign('depend', $data->depend);
    $template->assign('enabled', $data->enabled);
    
    $page->setContent($template);
    
    $design->setContentView($page);
?>
