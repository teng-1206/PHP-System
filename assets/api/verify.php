<?php
    // Include config.php
    include_once( realpath( dirname( __FILE__ ) . '//..//config/config.php' ) );

    // Include User class
    include_once( MODULES_PATH . 'user.php' );

    if ( isset( $_POST[ 'username' ] ) && isset( $_POST[ 'password' ] ) ) 
    {
        // Get username & password and escape HTML
        $username = htmlspecialchars( $_POST[ 'username' ] );
        $password = md5( htmlspecialchars( $_POST[ 'password' ] ) );

        // Define user controller
        $user_controller = new User_Controller();

        // Define user object
        $user = new User();
        $user->set( 'username', $username );
        $user->set( 'email', $username );
        $user->set( 'password', $password );
        
        // Check username
        $user_id = $user_controller->check_username( $conn2, $user );
        if ( $user_id != 0 )
        {
            echo json_encode( array( "result" => false, "message" => "Username Exist" ) );
            die();
        }

        // Create user
        $user_id = $user_controller->create( $conn2, $user );
        if ( is_null( $user_id ) )
        {
            echo json_encode( array( "result" => false, "message" => "Create user failed" ) );
            die();
        }

        // Create verified record
        /**
         * verify (true or false)
         * code (random six digit)
         * verify timestamp (15 minutes after verification email / 2FA email sent)
         * 2FA (true or false)
         */




        // Return JSON
        $respond = array(
            "result" => true
        );
        echo json_encode( $respond );
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