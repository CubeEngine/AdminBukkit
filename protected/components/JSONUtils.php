<?php
    class JSONUtils
    {
        const CONTENT_TYPE = 'Content-Type: application/json';

        private function __construct()
        {}

        public static function serializeUser($user, $serializeServers = false)
        {
            $user = User::get($user);
            if ($user !== null)
            {
                $servers = $user->getServers();
                $currentServer = $user->getSelectedServer();
                if ($serializeServers)
                {
                    foreach ($servers as $index => &$server)
                    {
                        $server = self::serializeServer($server);
                    }
                    $currentServer = Server::get($currentServer);
                }

                return array(
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => ($user->equals(User::getCurrent()) ? $user->getEmail() : null),
                    'loginip' => ($user->equals(User::getCurrent()) ? $user->getLoginIp() : null),
                    'servers' => $servers,
                    'currenserver' => $currentServer
                );
            }
            return null;
        }

        public static function serializeServer($server, $serializeUsers = false)
        {
            $server = Server::get($server);
            if ($server != null)
            {
                $members = $server->getMembers();
                $owner = $server->getOwner();
                if ($owner !== null)
                {
                    $owner = $owner->getId();
                }
                if ($serializeUsers)
                {
                    foreach ($members as $index => &$member)
                    {
                        $user = self::serializeUser(User::get($member));
                        if ($user !== null)
                        {
                            $member = $user;
                        }
                        else
                        {
                            unset($members[$index]);
                        }
                    }
                    $owner = self::serializeUser($owner);
                }

                return array(
                    'alias'     => $server->getAlias(),
                    'authkey'   => $server->getAuthKey(),
                    'host'      => $server->getHost(),
                    'id'        => $server->getId(),
                    'members'   => $members,
                    'owner'     => $owner,
                    'port'      => $server->getPort()
                );
            }
            return null;
        }

        public static function encode($value, $options = null)
        {
            if (function_exists('json_encode'))
            {
                return json_encode($value, $options);
            }
            throw new RuntimeException('Missing JSON functions!');
        }

        public static function decode($value, $assoc = false)
        {
            if (function_exists('json_decode'))
            {
                return json_decode($value, $assoc);
            }
            throw new RuntimeException('Missing JSON functions!');
        }
    }
?>
