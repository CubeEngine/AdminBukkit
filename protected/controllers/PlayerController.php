<?php
    class PlayerController extends AccessControlledController
    {
        public $defaultAction = 'list';
        private static $baseHeadAddress = 'http://s3.amazonaws.com/MinecraftSkins/';
        private static $defaultSkinPath;

        public function init()
        {
            parent::init();
            self::$defaultSkinPath = dirname(Yii::app()->basePath) . '/res/gfx/char.png';
        }

        public function actionList($world = null)
        {
            $idPrefix = ($world ? 'worldplayer' : 'player');
            $this->id = $idPrefix . '_list';
            $this->title = Yii::t('player', 'Playerlist');
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton($idPrefix . '_playerlist_refresh', Yii::t('generic', 'Refresh'));

            $this->render('list', array(
                'server' => $this->user->getCurrentServer(),
                'world' => $world,
                'idPrefix' => $idPrefix
            ));
        }

        public function actionView($player)
        {
            $this->id = 'player_view';
            $this->title = $player;
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('view_refresh', Yii::t('generic', 'Refresh'));

            $this->render('view', array(
                'server' => $this->user->getCurrentServer(),
                'player' => $player
            ));
        }

        public function actionUtils($player)
        {
            $this->id = 'player_utils';
            $this->title = $player;
            $this->render('utils', array(
                'server' => $this->user->getCurrentServer(),
                'player' => $player
            ));
        }

        public function actionHead($player, $size = 24)
        {
            if (is_numeric($size))
            {
                $targetSize = abs(intval($size));
            }
            else
            {
                throw new CHttpException(400, 'Size must be a number!');
            }
            $url = self::$baseHeadAddress . $player . '.png';

            $img = null;
            if (empty($player) || @getimagesize($url) === false)
            { // default
                $img = imagecreatefrompng(self::$defaultSkinPath);
            }
            else
            { // custom
                $img = imagecreatefrompng($url);
            }
            $new = imagecreatetruecolor($size, $size);
            imagealphablending($new, false);
            imagesavealpha($new, true);
            imagecopyresampled($new, $img, 0, 0, 8, 8, $size, $size, 8, 8);


            // Header
            $cacheLifetime = Yii::app()->params['cacheLifetime'];
            header('Content-Type: image/png');
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheLifetime) . ' GMT');
            header('Pragma: cache');
            header('Cache-Control: max-age=' . $cacheLifetime);

            imagepng($new);
        }
    }
?>
