<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//config//config.php" ) );

    // Destroy Session
    session_unset();
    session_destroy();

    // Destroy Cookie
    setcookie('user_id', "", time() - 1, '/');

    echo "<script>window.location.href='" . $config[ 'urls' ][ 'base' ] . "login'</script>";
?>