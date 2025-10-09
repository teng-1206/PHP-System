<?php
    // Include config.php
    include_once( realpath( dirname( __FILE__ ) . '//..//config/config.php' ) );

    // Include User class
    include_once( MODULES_PATH . 'user.php' );

    if ( isset( $_POST[ 'email' ] ) && isset( $_POST[ 'code' ] ) ) 
    {
        $email = htmlspecialchars( $_POST[ 'email' ] );
        $code  = htmlspecialchars( $_POST[ 'code' ] );

        // Define user controller
        $user_controller = new User_Controller();

        // Define user object
        $user = new User();
        $user->set( 'email', $email );
        $user->set( 'code', $code );
        
        // Verify code
        $user_id = $user_controller->verify_2fa( $conn2, $user );

        error_log( 'User ID: ' . $user_id );
        
        if ( $user_id != 0 )
        {
            // Set session for logged user
            $_SESSION[ 'user_id' ] = $user_id;

            // Set Cookie for login Id
            setcookie( 'user_id', $user_id, time() + 86400 * 30, '/' ); 
            setcookie('2fa_email', '', time() - 3600, '/');
            unset( $_COOKIE['2fa_email'] );
            echo json_encode( array( "result" => true, "message" => "2FA Verification Success" ) );
            die();
        } else {
            echo json_encode( array( "result" => false, "message" => "2FA Verification Failed" ) );
            die();
        }
    }
    else
    {
        // Return JSON
        $respond = array( 
            "result" => false,
            "message" => "Cannot direct access this page"
        );
        echo json_encode( $respond );
    }
?>