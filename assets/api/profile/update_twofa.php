<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "user.php" );


    if ( isset( $_POST[ 'user_id' ] ) && isset( $_POST[ 'twofa' ] ) )
    {
        $user = new User();
        $user->set( 'id', htmlspecialchars( $_POST[ 'user_id' ] ) );

        $user_controller = new User_Controller();
        $user = $user_controller->read( $conn2, $user );
        $user->set( 'twofa', htmlspecialchars( $_POST[ 'twofa' ] ) );
        $res = $user_controller->update( $conn2, $user );

        if ( $res )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    } else {
        echo json_encode( array( "result" => false, "error" => "Cannot direct access this page" ) );
    }
?>