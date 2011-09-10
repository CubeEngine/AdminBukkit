<?php
    return array(
        // Generell
        'default'               => 'home',
        'defaultLanguage'       => 'en',
        'timezone'              => 'Europe/Berlin',
        'database'              => 'SQLite',
        'mod_rewrite'           => true,

        // MySQL
        'mysql_host'            => 'localhost',
        'mysql_port'            => 3306,
        'mysql_database'        => 'adminbukkit',
        'mysql_user'            => 'root',
        'mysql_pass'            => '',
        'mysql_prefix'          => 'ab01_',
        
        // Session
        'sessionName'           => 'sid',
        'sessionCookieLifetime' => 60 * 60 * 1,
        
        // Security
        'databaseDir'           => CONFIG_PATH,
        'encryptionKey'         => 'ozgo8g/(&FO=(&FO=)/T%L)G(g86fouzholb87fk',
        'staticSalt'            => '/(&FITV/&%F/&%DU&%V%I&RV/&%D/J%$($%$(/)(=)/&{]{]{[]{avI/&RTFJZ&FUJ/&ZGKu6kiu6rjuz6tjZ%FIU&TdhzfgkutudzTFI/%FI7z6tfu675iuzb7jRJ(/T/%ei8O(&REKI/Go7fujh65',
        
        // Debugging
        'displayErrors'         => true,
        'logLevel'              => 5
    );
?>
