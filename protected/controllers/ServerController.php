<?php
    class ServerController extends AccessControlledController
    {
        public $defaultAction = 'show';

        public function actionView($id = null)
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
            $this->utilButton = new ToolbarButton('server', Yii::t('server', 'Edit'), $this->createUrl('server/edit', array('id' => $server->getId())));

            $this->render('view', array('server' => $server));
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
                $serverForm->setAttributes($_POST['ServreForm']);
                if ($serverForm->validate())
                {
                    Server::createServer(
                        $serverForm->alia,
                        $serverForm->host,
                        $serverForm->port,
                        $serverForm->authkey,
                        $this->user->getId()
                    );
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
            $server = Server::get($id);
            if ($server !== null)
            {
                $this->user->setCurrentServer($server);
                
            }
        }
    }
?>
