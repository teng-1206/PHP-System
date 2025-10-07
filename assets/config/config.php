<?php

    $envFile = __DIR__ . '/.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue; // Skip comments
            
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }

    // ! Sandbox
    defined( 'DOMAIN_NAME' )
        or define( 'DOMAIN_NAME', 'localhost' );

    $config = array(
    "db" => array(
        "db1" => array(
            "dbname"   => 'ngqitengcom_system',
            "username" => 'root',
            "password" => '',
            "host"     => 'localhost'
        ),
        "db2" => array(
            "dbname"   => 'ngqitengcom_users',
            "username" => 'root',
            "password" => '',
            "host"     => 'localhost'
        ),
    ),
    "urls" => array(
        "base"      => "https://" . DOMAIN_NAME . "/PHP-System/",
        "api"       => "https://" . DOMAIN_NAME . "/PHP-System/assets/api/",
        "config"    => "https://" . DOMAIN_NAME . "/PHP-System/assets/config/",
        "css"       => "https://" . DOMAIN_NAME . "/PHP-System/assets/css/",
        "docs"      => "https://" . DOMAIN_NAME . "/PHP-System/assets/docs/",
        "img"       => "https://" . DOMAIN_NAME . "/PHP-System/assets/img/",
        "js"        => "https://" . DOMAIN_NAME . "/PHP-System/assets/js/",
        "modules"   => "https://" . DOMAIN_NAME . "/PHP-System/assets/modules/",
        "plugins"   => "https://" . DOMAIN_NAME . "/PHP-System/assets/plugins/",
        "templates" => "https://" . DOMAIN_NAME . "/PHP-System/assets/templates/",
        "uploads"   => "https://" . DOMAIN_NAME . "/PHP-System/assets/uploads/",
        "vendor"   => "https://" . DOMAIN_NAME . "/PHP-System/assets/vendor/",
    ),
    "paths" => array(
        "resources" => "/path/to/assets",
        "images" => array(
            "content" => $_SERVER[ 'DOCUMENT_ROOT' ] . "/images/content",
            "layout"  => $_SERVER[ 'DOCUMENT_ROOT' ] . "/images/layout"
        )
    )
);

    // ! Production
    // defined( 'DOMAIN_NAME' )
    //     or define( 'DOMAIN_NAME', getenv( 'DOMAIN_NAME' ) );

    // $config = array(
    //     "db" => array(
    //         "db1" => array(
    //             "dbname"   => getenv( 'DB_DATABASE' ),
    //             "username" => getenv( 'DB_USERNAME' ),
    //             "password" => getenv( 'DB_PASSWORD' ),
    //             "host"     => getenv( 'DB_HOST' )
    //         ),
    //         "db2" => array(
    //             "dbname"   => getenv( 'DB_DATABASE_2' ),
    //             "username" => getenv( 'DB_USERNAME_2' ),
    //             "password" => getenv( 'DB_PASSWORD_2' ),
    //             "host"     => getenv( 'DB_HOST_2' )
    //         ),
    //     ),
    //     "urls" => array(
    //         "base"      => "https://" . DOMAIN_NAME . "/",
    //         "api"       => "https://" . DOMAIN_NAME . "/assets/api/",
    //         "config"    => "https://" . DOMAIN_NAME . "/assets/config/",
    //         "css"       => "https://" . DOMAIN_NAME . "/assets/css/",
    //         "docs"      => "https://" . DOMAIN_NAME . "/assets/docs/",
    //         "img"       => "https://" . DOMAIN_NAME . "/assets/img/",
    //         "js"        => "https://" . DOMAIN_NAME . "/assets/js/",
    //         "modules"   => "https://" . DOMAIN_NAME . "/assets/modules/",
    //         "plugins"   => "https://" . DOMAIN_NAME . "/assets/plugins/",
    //         "templates" => "https://" . DOMAIN_NAME . "/assets/templates/",
    //         "uploads"   => "https://" . DOMAIN_NAME . "/assets/uploads/",
    //         "vendor"   => "https://" . DOMAIN_NAME . "/assets/vendor/",
    //     ),
    //     "paths" => array(
    //         "resources" => "/path/to/assets",
    //         "images" => array(
    //             "content" => $_SERVER[ 'DOCUMENT_ROOT' ] . "/images/content",
    //             "layout"  => $_SERVER[ 'DOCUMENT_ROOT' ] . "/images/layout"
    //         )
    //     )
    // );

    include_once( 'conn.php' );

    defined( 'ASSETS_PATH' )
        or define( 'ASSETS_PATH', realpath( dirname( __FILE__ ) . '//..//' ) );
        
    defined( 'API_PATH' )
        or define( 'API_PATH', ASSETS_PATH . '//api//' );

    defined( 'CONFIG_PATH' )
        or define( 'CONFIG_PATH', ASSETS_PATH . '//config//' );

    defined( 'CSS_PATH' )
        or define( 'CSS_PATH', ASSETS_PATH . '//css//' );

    defined( 'DOCS_PATH' )
        or define( 'DOCS_PATH', ASSETS_PATH . '//docs//' );
        
    defined( 'IMG_PATH' )
        or define( 'IMG_PATH', ASSETS_PATH . '//img//' );

    defined( 'JS_PATH' )
        or define( 'JS_PATH', ASSETS_PATH . '//js//' );

    defined( 'MODULES_PATH' )
        or define( 'MODULES_PATH', ASSETS_PATH . '//modules//' );

    defined( 'PLUGINS_PATH' )
        or define( 'PLUGINS_PATH', ASSETS_PATH . '//plugins//' );   
    
    defined( 'TEMPLATES_PATH' )
        or define( 'TEMPLATES_PATH', ASSETS_PATH . '//templates//' );

    defined( 'UPLOADS_PATH' )
        or define( 'UPLOADS_PATH', ASSETS_PATH . '//uploads//' );

    defined( 'VENDOR_PATH' )
        or define( 'VENDOR_PATH', ASSETS_PATH . '//vendor//' );

    // ! Email
    defined( 'SMTP_EMAIL' )
        or define( 'SMTP_EMAIL', getenv( 'MAIL_FROM_ADDRESS' ) );

    defined( 'SMTP_NAME' )
        or define( 'SMTP_NAME', getenv( 'MAIL_FROM_NAME' ) );
        
    defined( 'SMTP_HOST' )
        or define( 'SMTP_HOST', getenv( 'MAIL_HOST' ) );

    defined( 'SMTP_AUTH' )
        or define( 'SMTP_AUTH', true );

    defined( 'SMTP_USERNAME' )
        or define( 'SMTP_USERNAME', getenv( 'MAIL_USERNAME' ) );

    defined( 'SMTP_PASSWORD' )
        or define( 'SMTP_PASSWORD', getenv( 'MAIL_PASSWORD' ) );

    defined( 'SMTP_SECURE' )
        or define( 'SMTP_SECURE', getenv( 'MAIL_ENCRYPTION' ) );

    defined( 'SMTP_PORT' )
        or define( 'SMTP_PORT', getenv( 'MAIL_PORT' ) );

    include_once( MODULES_PATH . 'cryptography.php' );
    $crypto = new Cryptography();

    session_start();
    // session_cache_expire( 60 );
    
    // Current Page
    $current_page = basename( $_SERVER[ 'PHP_SELF' ] );

?>