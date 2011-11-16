<?php
    import('Controller.Module');
    import('Request.Route');

    class DownloadsModule extends Module
    {
        public function route(Request $request)
        {
            return new Route('index', array());
        }
    }
    
    __halt_compiler();

    $file = trim(Request::get('file', ''));
    $lang = Lang::instance('downloads');
    $page = new Page('downloads', $lang['downloads']);
    $page->setBack($lang['home'], Router::instance()->getBasePath());
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
