<?php
    $file = trim(Request::get('file', ''));
    $lang = Lang::instance('downloads');
    $page = new Page('downloads');
    $toolbar = new Toolbar($lang['downloads']);
    $toolbar->setBack($lang['home'], Router::instance()->getBasePath());
    $page->addSubtemplate('toolbar', $toolbar);
    $template = new Template('pages/downloads');
    if (!empty($file) && !preg_match('/\.\./', $file))
    {
        $path = DOWNLOAD_PATH . DS . $file;
        if (is_readable($path))
        {
            header('Content-Type: application/force-download');
            header('Content-Length: ' . filesize($path));
            header('Content-Disposition: attachment;filename="' . basename($file) . '"');
            $handle = fopen($path, 'rb');
            fpassthru($handle);
            fclose($handle);
            Statistics::increment('downloads.' . str_replace('.', '\.', basename($file)));
        }
    }
    $page->setContent($template);
    
    $design->setContentView($page);
?>
