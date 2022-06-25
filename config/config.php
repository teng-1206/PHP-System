<?php

    session_start();

    $config = array(
        "db" => array(
            "db1" => array(
                "dbname"   => "system",
                "username" => "root",
                "password" => "",
                "host"     => "localhost"
            ),
            // "db2" => array(
            //     "dbname"   => "database2",
            //     "username" => "dbUser",
            //     "password" => "pa$$",
            //     "host"     => "localhost"
            // )
        ),
        "urls" => array(
            "base"      => "http://localhost/php-system/",
            "api"       => "http://localhost/php-system/api/",
            "config"    => "http://localhost/php-system/config/",
            "css"       => "http://localhost/php-system/css/",
            "img"       => "http://localhost/php-system/img/",
            "js"        => "http://localhost/php-system/js/",
            "modules"   => "http://localhost/php-system/modules/",
            "plugins"   => "http://localhost/php-system/plugins/",
            "templates" => "http://localhost/php-system/templates/",
            "uploads"   => "http://localhost/php-system/uploads/",
            
        ),
        "paths" => array(
            "resources" => "/path/to/assets",
            "images" => array(
                "content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
                "layout"  => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
            )
        )
    );

    include_once( 'conn.php' );

    defined("ASSETS_PATH")
        or define("ASSETS_PATH", realpath( dirname( __FILE__ ) . '/..//' ) );
        
    defined("API_PATH")
        or define("API_PATH", ASSETS_PATH . '/api/');

    defined("CONFIG_PATH")
        or define("CONFIG_PATH", ASSETS_PATH . '/config/');

    defined("CSS_PATH")
        or define("CSS_PATH", ASSETS_PATH . '/css/');

    defined("IMG_PATH")
        or define("IMG_PATH", ASSETS_PATH . '/img/');

    defined("JS_PATH")
        or define("JS_PATH", ASSETS_PATH . '/js/');

    defined("MODULES_PATH")
        or define("MODULES_PATH", ASSETS_PATH . '/modules/');

    defined("PLUGINS_PATH")
        or define("PLUGINS_PATH", ASSETS_PATH . '/plugins/');   
    
    defined("TEMPLATES_PATH")
        or define("TEMPLATES_PATH", ASSETS_PATH . '/templates/');

    defined("UPLOADS_PATH")
        or define("UPLOADS_PATH", ASSETS_PATH . '/uploads/');

?>