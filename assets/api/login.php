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
        $user->set( 'password', $password );

        // Get user exist result
        $user_id = $user_controller->login( $conn2, $user );
        $user_exist = $user_id != 0;

        if ( $user_exist ) 
        {
            // Set session for logged user
            $_SESSION[ 'user_id' ] = $user_id;
        }

        // Return JSON
        $respond = array(
            "result" => $user_exist
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