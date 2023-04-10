<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "wallet.php" );

    if ( isset( $_POST ) )
    {
        $wallet = new Wallet();
        $wallet->set( 'id', $_POST[ 'id' ] );

        $wallet_controller = new Wallet_Controller();
        $wallet = $wallet_controller->read( $conn, $wallet );
        $wallet = $wallet_controller->convert( $wallet );
        if ( $wallet->get( 'status' ) == "Default" )
        {
            echo json_encode( array( "result" => false, "message" => "This wallet cannot delete" ) );
            die();
        }
        $res = $wallet_controller->delete( $conn, $wallet );

        if ( $res )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
?>