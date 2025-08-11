<?php
    // Include config.php
    include_once( realpath( dirname( __FILE__ ) . '//..//config/config.php' ) );

    // Include User class
    include_once( MODULES_PATH . 'user.php' );

    if ( isset( $_POST[ 'email' ] ) && isset( $_POST[ 'verification_code' ] ) ) 
    {
        $email             = htmlspecialchars( $_POST[ 'email' ] );
        $verification_code = htmlspecialchars( $_POST[ 'verification_code' ] );

        // Define user controller
        $user_controller = new User_Controller();

        // Define user object
        $user = new User();
        $user->set( 'email', $email );
        $user->set( 'verification_code', $verification_code );
        
        // Check username
        $user_id = $user_controller->verification_code( $conn2, $user );
        if ( $user_id != 0 )
        {
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