<?php
    class IndexController extends Controller
    {
        public $defaultAction = 'home';

        public function actionHome()
        {

            $this->id = 'home';
            $this->title = Yii::t('home', Yii::t('home', 'Home'));
            $this->utilButton = new ToolbarButton('about', Yii::t('home', 'About'), $this->createUrl('about'));
            $this->utilButton->setDataAttribute('rel', 'dialog');
            $this->utilButton->setDataAttribute('transition', 'slideup');

            if (Yii::app()->user->isGuest)
            {
                $this->render('home_guests');
            }
            else
            {
                $this->render('home');
            }
        }

        public function actionAbout()
        {
            $this->id = 'about';
            $this->title = Yii::t('home', 'About');
            $this->render('about');
        }

        public function actionDownloads($file = null)
        {
            if (!$file)
            {
                $this->id = 'downloads';
                $this->title = Yii::t('downloads', 'Downloads');
                $this->backButton = new BackToolbarButton();
                $this->render('downloads');
            }
            else
            {
                $file = trim($file);
                if (!preg_match('/\.\./', $file))
                {
                    $path = Yii::app()->params['downloadPath'] . '/' . $file;
                    if (is_readable($path))
                    {
                        header('Content-Type: application/force-download');
                        header('Content-Length: ' . filesize($path));
                        header('Content-Disposition: attachment;filename="' . basename($file) . '"');
                        $handle = fopen($path, 'rb');
                        fpassthru($handle);
                        fclose($handle);

                        // stats
                        $stat = new Statistic('downloads.' . str_replace('.', '\.', basename($file)));
                        $stat->increment();
                    }
                    else
                    {
                        throw new CHttpException(404, 'File not found!');
                    }
                }
                else
                {
                    throw new CHttpException(400, 'Invalid file name!');
                }
            }
        }

        public function actionStats()
        {
            $this->backButton = new BackToolbarButton();

            $data = array(
                'userStats' => Statistic::getValues('user.*'),
                'apiSuccess' => Statistic::getValues('api.succeeded.*'),
                'apiFailCount' => 0,
                'dlStats' => array(),
                'messages' => require Yii::getPathOfAlias('application.messages') . '/en/stats.php'
            );
            $fails = Statistic::getValues('api.failed.*');
            foreach ($fails as $fail)
            {
                $data['apiFailCount'] += $fail['value'];
            }
            $dlStats = Statistic::getValues('downloads.*');
            $match = array();
            foreach ($dlStats as &$entry)
            {
                preg_match('/\.((.*(\\\.)*)*)$/', $entry['index'], $match);
                $entry['index'] = str_replace('\.', '.', $match[1]);
            }

            $this->render('stats', $data);
        }

        public function actionError()
        {
            $this->backButton = new BackToolbarButton();

            $error = Yii::app()->errorHandler->error;
            if ($error)
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo $error['message'];
                }
                else
                {
                    $this->render('error', $error);
                }
            }
        }
    }
?>
