<?php

    include_once( realpath( dirname( __FILE__ ) . "//..//config//config.php" ) );

    session_unset();
    session_destroy();

    echo "<script>window.location.href='" . $config[ 'urls' ][ 'base' ] . "login'</script>";

?>