<?php

    include_once( realpath( dirname( __FILE__ ) . "./../config/config.php" ) );
    include_once( MODULES_PATH . "/user.php" );

    if( isset( $_POST ) ) {
        $user = new User();
        $user->set( 'username', $crypto->encrypt( $_POST[ 'username' ] ) );
        $user->set( 'password', $crypto->hash( $_POST[ 'password' ] ) );
        $user_data_connector = new User_Data_Connector();
        $user = $user_data_connector->login( $conn, $user );
        if ( isset( $user ) ) 
        {
            $_SESSION[ 'user' ] = $user;
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }

?>