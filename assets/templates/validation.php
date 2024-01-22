<?php
    // Check session or cookie 
    // If got session or cookie but current page is on login page then redirect to dashboard
    if ( isset( $_SESSION[ 'user_id' ] ) || isset( $_COOKIE[ 'user_id' ] ) )
    {
        if ( ! isset( $_SESSION[ 'user_id' ] ) ) {
            $_SESSION[ 'user_id' ] = $_COOKIE[ 'user_id' ];
            echo "Session: " .  $_SESSION[ 'user_id' ];
            echo "Cookie: " .  $_COOKIE[ 'user_id' ];
        }

        if ( $current_page == 'login.php' ) {
            echo "<script>location.href='" . $config[ 'urls' ][ 'base' ] . "dashboard'</script>";
        }
    }

    // If no session or cookie then redirect to login page
    if ( ! isset( $_SESSION[ 'user_id' ] ) && ! isset( $_SESSION[ 'user_id' ] ) )
    {
        echo "<script>location.href='" . $config[ 'urls' ][ 'base' ] . "'</script>";
    }
?>