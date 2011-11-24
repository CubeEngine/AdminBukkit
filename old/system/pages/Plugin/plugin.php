<?php
    $lang = Lang::instance('plugin');
    $plugin = trim(Request::get('plugin'));
    if ($plugin === '')
    {
        Router::instance()->redirectToPage('plugins', $lang['noplugin']);
    }
    $page = new Page('plugin', $lang['plugininfo'], true);
    $page->setBack(Lang::instance('generic')->get('btn_back'));
    $template = new Template('pages/plugin');

    $api = new ApiBukkit($_SESSION['user']->getServerAddress(), $_SESSION['user']->getApiPort(), $_SESSION['user']->getApiAuthKey());
    $response = $api->request('plugin', 'info', array(
        'format' => 'json',
        'plugin' => $plugin
    ));
    if ($response->getStatus() > 204)
    {
        $error = explode(',', $response->getBody());
        $err = null;
        if ($error[0] == '3')
        {
            $err = $lang['pluginunavailable'];
        }
        else
        {
            $err = $lang['failedtoload'];
        }
        Router::instance()->redirectToPage('plugins', $err);
    }
    $data = json_decode($response->getBody());
    if ($data === null)
    {
        Router::instance()->redirectToPage('plugins', 'Konnte keine Informationen zum Plugin "' . $plugin . '" abrufen');
    }
    $template->assign('pluginName', $data->name)
             ->assign('fullName', $data->fullName)
             ->assign('dataFolder', $data->dataFolder)
             ->assign('version', $data->version)
             ->assign('description', $data->description)
             ->assign('website', $data->website)
             ->assign('authors', $data->authors)
             ->assign('commands', $data->commands)
             ->assign('depend', $data->depend)
             ->assign('enabled', $data->enabled);
    
    $page->setContent($template);
    
    $design->setContentView($page);
?>
