<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/page';

    public $id;
    public $title;
    public $backButton;
    public $utilButton;

    public function init()
    {
        parent::init();
        if( isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && ($n = preg_match_all('/([\w\-_]+)\s*(;\s*q\s*=\s*(\d*\.\d*))?/', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches)) > 0)
        {
            $path = Yii::getPathOfAlias('application.messages') . '/';
            $languages = array();
            for ($i = 0; $i < $n; ++$i)
            {
                $languages[$matches[1][$i]] = empty($matches[3][$i]) ? 1.0 : floatval($matches[3][$i]);
            }
            arsort($languages);
            foreach($languages as $language => $pref)
            {
                $language = CLocale::getCanonicalID($language);
                if (is_readable($path . $language))
                {
                    Yii::app()->language = $language;
                    break;
                }
            }
        }
    }
}