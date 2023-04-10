<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "wallet.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $wallet = new Wallet();
        $wallet->set( 'id', $_POST[ 'id' ] );

        $wallet_controller = new Wallet_Controller();
        $wallet = $wallet_controller->read( $conn, $wallet );
        $wallet = $crypto->decrypt_object( $wallet );
        $wallet = $wallet_controller->convert( $wallet );

        $wallet->set( 'name', $crypto->encrypt( $_POST[ 'name' ] ) );
        $wallet->set( 'status', $crypto->encrypt( $_POST[ 'status' ] ) );
        $wallet->set( 'category', $crypto->encrypt( $_POST[ 'category' ] ) );
        $wallet->set( 'amount', $crypto->encrypt( number_format( $_POST[ 'amount' ] , 2, '.', ',' ) ) );

        $res = $wallet_controller->update( $conn, $wallet );

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