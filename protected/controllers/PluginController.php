<?php
    class PluginController extends AccessControlledController
    {
        public $defaultAction = 'list';

        public function actionList()
        {
            $this->id = 'plugin_list';
            $this->title = Yii::t('plugin', 'Pluginlist');
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('plugin_list_refresh', Yii::t('generic', 'Refresh'));
            $this->render('list', array('server' => $this->user->getSelectedServer()));
        }

        public function actionView($plugin)
        {
            $this->id = 'plugin_view';
            $this->title = $plugin;
            $this->backButton = new BackToolbarButton();
            //$this->utilButton = new ToolbarButton('plugin_list_refresh', Yii::t('generic', 'Refresh'));
            
            $server = $this->user->getSelectedServer();
            $api = new ApiBukkit($server->getHost(), $server->getPort(), $server->getAuthKey());
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
                    $err = Yii::t('plugin', 'Plugin no longer available.');
                }
                else
                {
                    $err = Yii::t('plugin', 'Could not load the plugin information.');
                }
                $this->redirect(array('plugin/list', array('_message' => $err)));
            }
            $data = json_decode($response->getBody());
            if ($data === null)
            {
                Router::instance()->redirectToPage('plugins', 'Konnte keine Informationen zum Plugin "' . $plugin . '" abrufen');
            }
            
            
            $this->render('view', array(
                'server' => $server,
                'pluginName' => $data->name,
                'fullName' => $data->fullName,
                'dataFolder' => $data->dataFolder,
                'version' => $data->version,
                'description' => $data->description,
                'website' => $data->website,
                'authors' => $data->authors,
                'commands' => $data->commands,
                'depend' => $data->depend,
                'enabled' => $data->enabled
            ));
        }
    }
?>
