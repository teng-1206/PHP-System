<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "user.php" );


    if ( isset( $_POST[ 'user_id' ] ) && isset( $_POST[ 'password' ] ) )
    {
        $user = new User();
        $user->set( 'id', htmlspecialchars( $_POST[ 'user_id' ] ) );
        $user->set( 'password', htmlspecialchars( $_POST[ 'password' ] ) );

        $user_controller = new User_Controller();
        $is_valid = $user_controller->validate_password( $conn2, $user );

        echo json_encode( array( "result" => $is_valid ) );
    } else {
        echo json_encode( array( "result" => false, "error" => "Cannot direct access this page" ) );
    }
?>