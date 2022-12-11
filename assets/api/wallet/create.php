<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "/wallet.php" );

    if ( isset( $_POST ) )
    {
        $wallet = new Wallet();
        $wallet->set( 'name', $crypto->encrypt( $_POST[ 'name' ] ) );
        $wallet->set( 'amount', $crypto->encrypt( $_POST[ 'amount' ] ) );
        $wallet->set( 'fk_user_id', $_POST[ 'fk_user_id' ] );

        $wallet_data_connector = new Wallet_Data_Connector();
        $wallet_id = $wallet_data_connector->create( $conn, $wallet );

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