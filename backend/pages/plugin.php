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
    
    
    $_SERVER['PATH_INFO'] = '/plugin/info';
    $_POST['format'] = 'json';
    $_POST['plugin'] = $plugin;
    ob_start();
    include BACKEND_PATH . DS . 'apiproxy.php';
    $rawData = ob_get_clean();
    $data = json_decode($rawData);
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
    
    $design->setContentTpl($page);
?>
