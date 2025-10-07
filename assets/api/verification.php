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
        $user_id = $user_controller->verify_code( $conn2, $user );
        
        if ( $user_id != 0 )
        {
            setcookie('verify_email', '', time() - 3600, '/');
            unset( $_COOKIE['verify_email'] );
            echo json_encode( array( "result" => true, "message" => "Verification Success" ) );
            die();
        } else {
            echo json_encode( array( "result" => false, "message" => "Verification Failed" ) );
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
        die();
    }
?>