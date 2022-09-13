<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "/wallet.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $wallet = new Wallet();
        $wallet->set( 'id', $_POST[ 'id' ] );

        $wallet_data_connector = new Wallet_Data_Connector();
        $wallet = $wallet_data_connector->read( $conn, $wallet );
        $wallet = $crypto->decrypt_object( $wallet );
        $wallet = $wallet_data_connector->convert( $wallet );

        if ( ! is_null( $wallet ) )
        {
            $res = array(
                "result"      => true,
                "data" => array(
                    "id"         => $wallet->get( 'id' ),
                    "name"       => $wallet->get( 'name' ),
                    "amount"     => $wallet->get( 'amount' ),
                    "fk_user_id" => $wallet->get( 'fk_user_id' ),
                ),
            );
            echo json_encode( $res );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
?>