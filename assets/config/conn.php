<?php

    // ! System Database
    try {
        $conn = new PDO(
            "mysql:host=" . $config[ 'db' ][ 'db1' ][ 'host' ] . ";dbname=" . $config[ 'db' ][ 'db1' ][ 'dbname' ],
            $config[ 'db' ][ 'db1' ][ 'username' ],
            $config[ 'db' ][ 'db1' ][ 'password' ]
        );
        $conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch( PDOException $ex ) {
        die( "Connection failed: " . $ex->getMessage() );
    }

    // ! User Database
    try {
        $conn2 = new PDO(
            "mysql:host=" . $config[ 'db' ][ 'db2' ][ 'host' ] . ";dbname=" . $config[ 'db' ][ 'db2' ][ 'dbname' ],
            $config[ 'db' ][ 'db2' ][ 'username' ],
            $config[ 'db' ][ 'db2' ][ 'password' ]
        );
        $conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch( PDOException $ex ) {
        die( "Connection failed: " . $ex->getMessage() );
    }

?>