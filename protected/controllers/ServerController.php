<?php
    class ServerController extends AccessControlledController
    {
        public $defaultAction = 'view';

        public function actionView($id = null)
        {
            $server = $this->user->getCurrentServer();
            $serverSelected = true;
            if ($id !== null)
            {
                $serverSelected = false;
                $server = Server::get($id);
            }
            if ($server === null)
            {
                $this->redirect(array('server/list'));
            }
                

            $this->title = $server->getAlias();
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('server', Yii::t('server', 'Edit'), $this->createUrl('server/edit', array('id' => $server->getId())));

            $this->render('view', array(
                'server' => $server,
                'serverSelected' => $serverSelected
            ));
        }

        public function actionList()
        {
            $this->title = Yii::t('server', 'Your servers');
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('server', '', $this->createUrl('server/add'));
            $this->utilButton->setDataAttribute('icon', 'add');
            $this->utilButton->setDataAttribute('iconpos', 'notext');

            $servers = array();
            foreach ($this->user->getServers() as $serverID)
            {
                $servers[] = Server::get($serverID);
            }

            $this->render('list', array('servers' => $servers));
        }

        public function actionEdit($id = null)
        {
            $server = $this->user->getCurrentServer();
            if ($id !== null)
            {
                $server = Server::get($id);
            }
            if ($server === null)
            {
                $this->redirect(array('server/list'));
            }

            $this->title = $server->getAlias();
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('server', Yii::t('server', 'Delete'), $this->createUrl('server/delete', array('id' => $server->getId())));

            $serverForm = new ServerForm('edit', $server);
            if (isset($_POST['ServerForm']))
            {
                $serverForm->setAttributes($_POST['ServerForm']);
                if ($serverForm->validate())
                {
                    $server->setAlias($serverForm->alias)
                           ->setHost($serverForm->host)
                           ->setPort($serverForm->port)
                           ->setAuthKey($serverForm->authkey)
                           ->save();
                    Yii::app()->session['message'] = new Message(Yii::t('server', 'Successfully updated!'), Yii::t('server', 'The server {alias} was successfully updated.', array('{alias}' => $serverForm->alias)));
                    $this->redirect(array('server/list'));
                }
                else
                {
                    Yii::app()->session['message'] = new Message(Yii::t('server', 'Failt to edit!'), $serverForm->getErrors());
                }
            }

            $this->render('edit', array('model' => $serverForm));
        }

        public function actionDelete($id = null)
        {
            $server = $this->user->getCurrentServer();
            if ($id !== null)
            {
                $server = Server::get($id);
            }
            if ($server === null)
            {
                $this->redirect(array('server/list'));
            }

            $this->title = Yii::t('server', 'Delete server');
            $this->backButton = new BackToolbarButton();

            $confirmForm = new ConfirmForm('delete');
            if (isset($_POST['ConfirmForm']))
            {
                $confirmForm->setAttributes($_POST['ConfirmForm']);
            }

            $this->render('delete', array('model' => $confirmForm));
        }

        public function actionAdd()
        {
            $this->title = Yii::t('server', 'Add a server');
            $this->backButton = new BackToolbarButton();
            //$this->utilButton = new ToolbarButton('server', Yii::t('server', 'My servers'), $this->createUrl('server/list'));
            
            $serverForm = new ServerForm('add');
            if (isset($_POST['ServerForm']))
            {
                $serverForm->setAttributes($_POST['ServerForm']);
                if ($serverForm->validate())
                {
                    $this->user->addServer(Server::createServer(
                        $serverForm->alias,
                        $serverForm->host,
                        $serverForm->port,
                        $serverForm->authkey,
                        $this->user->getId()
                    ))->save();
                    Yii::app()->session['message'] = new Message(Yii::t('server', 'Successfully added!'), Yii::t('server', 'The server {alias} was successfully added.', array('{alias}' => $serverForm->alias)));
                    $this->redirect(array('server/list'));
                }
                else
                {
                    Yii::app()->session['message'] = new Message(Yii::t('server', 'Failt to add!'), $serverForm->getErrors());
                }
            }
            $this->render('add', array('model' => $serverForm));
        }

        public function actionInfo($id = null)
        {
            $this->id = 'server';
            $this->title = Yii::t('server', 'Serverinfo');
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('server_refresh', Yii::t('generic', 'Refresh'));
            
            $server = $this->user->getCurrentServer();
            if ($id !== null)
            {
                $server = Server::get($id);
            }
            if ($server === null)
            {
                $this->redirect(array('server/list'));
            }

            $this->render('info', array('server' => $server));
        }
        
        public function actionSelect($id)
        {
            $server = $this->user->getServer($id);
            if ($server !== null)
            {
                $this->title = Yii::t('server', 'Server selected');
                $this->user->setCurrentServer($server)->save();
            }
            else
            {
                $this->title = Yii::t('server', 'Server not available');
            }
            
            $this->render('select', array(
                'server' => $server
            ));
        }

        public function actionConsole()
        {
            $this->id = 'server_console';
            $this->title = Yii::t('server', 'Console');
            $this->backButton = new BackToolbarButton();
            $this->utilButton = new ToolbarButton('autorefreshing', Yii::t('server', 'Refreshing off'));

            $this->render('console', array('server' => $this->user->getCurrentServer()));
        }

        public function actionPlayerbans()
        {
            $this->id = 'server_playerbans';
            $this->title = Yii::t('server', 'Playerbans');
            $this->utilButton = new ToolbarButton('server_banplayer', Yii::t('server', 'Ban'));

            $this->render('popups/playerbans', array('server' => $this->user->getCurrentServer()));
        }

        public function actionIpbans()
        {
            $this->id = 'server_ipbans';
            $this->title = Yii::t('server', 'IP Bans');
            $this->utilButton = new ToolbarButton('server_banip', Yii::t('server', 'Ban'));

            $this->render('popups/ipbans', array('server' => $this->user->getCurrentServer()));
        }

        public function actionWhitelist()
        {
            $this->id = 'server_whitelist';
            $this->title = Yii::t('server', 'Whitelist');
            $this->utilButton = new ToolbarButton('server_addwhitelist', Yii::t('server', 'Add'));

            $this->render('popups/whitelist', array('server' => $this->user->getCurrentServer()));
        }

        public function actionOperators()
        {
            $this->id = 'server_operators';
            $this->title = Yii::t('server', 'Operators');
            $this->utilButton = new ToolbarButton('server_op', Yii::t('server', 'Op'));

            $this->render('popups/operators', array('server' => $this->user->getCurrentServer()));
        }
    }
?>
