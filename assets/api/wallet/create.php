<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "wallet.php" );

    if ( isset( $_POST ) )
    {
        $wallet = new Wallet();
        // $wallet->set( 'name', $crypto->encrypt( $_POST[ 'name' ] ) );
        $wallet->set( 'name', ( $_POST[ 'name' ] ) );
        // $wallet->set( 'status', $crypto->encrypt( $_POST[ 'status' ] ) );
        $wallet->set( 'status', ( $_POST[ 'status' ] ) );
        // $wallet->set( 'category', $crypto->encrypt( $_POST[ 'category' ] ) );
        $wallet->set( 'category', ( $_POST[ 'category' ] ) );
        // $wallet->set( 'amount', $crypto->encrypt( number_format( $_POST[ 'amount' ] , 2, '.', ',' ) ) );
        $wallet->set( 'amount', ( number_format( $_POST[ 'amount' ] , 2, '.', '' ) ) );
        $wallet->set( 'fk_user_id', $_POST[ 'fk_user_id' ] );

        $wallet_controller = new Wallet_Controller();
        $wallet_id = $wallet_controller->create( $conn, $wallet );

        if ( isset( $wallet_id ) )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
?>