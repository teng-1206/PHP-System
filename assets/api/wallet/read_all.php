<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "wallet.php" );

    if ( isset( $_POST[ 'fk_user_id' ] ) )
    {
        $wallet = new Wallet();
        $wallet->set( 'fk_user_id', $_POST[ 'fk_user_id' ] );

        $wallet_data_connector = new Wallet_Data_Connector();
        $all_wallet = $wallet_data_connector->read_all_by_user_id( $conn, $wallet );
        $all_wallet = $crypto->decrypt_all_object( $all_wallet );

        if ( ! is_null( $all_wallet ) )
        {
            $res = array(
                "result" => true,
                "data" => $all_wallet,
            );
            echo json_encode( $res );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
    else
    {
        echo json_encode( array( "result" => false ) );
    }
?>