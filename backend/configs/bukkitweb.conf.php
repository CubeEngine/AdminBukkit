<?php
    return array(
        // Generell
        'default'               => 'home',
        'defaultLanguage'       => 'en',
        'timezone'              => 'Europe/Berlin',
        'database'              => 'MySQL',
        'mod_rewrite'           => true,
        'cacheLifetime'         => 60 * 60 * 24,
        'databaseDir'           => CONFIG_PATH,

        // MySQL
        'mysql_host'            => 'localhost',
        'mysql_port'            => 3306,
        'mysql_database'        => 'test',
        'mysql_user'            => 'root',
        'mysql_pass'            => '',
        'mysql_prefix'          => '',
        
        // Session
        'sessionName'           => 'sid',
        'sessionCookieLifetime' => 60 * 60 * 4,
        
        // Security
        'staticSalt'            => '/(&FITV/&%F/&%DU&%V%I&RV/&%D/J%$($%$(/)(=)/&{]{]{[]{avI/&RTFJZ&FUJ/&ZGKu6kiu6rjuz6tjZ%FIU&TdhzfgkutudzTFI/%FI7z6tfu675iuzb7jRJ(/T/%ei8O(&REKI/Go7fujh65',
        
        // Debugging
        'displayErrors'         => true,
        'logLevel'              => 5
    );
?>
