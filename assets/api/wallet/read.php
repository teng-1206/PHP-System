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

        if ( ! is_null( $wallet ) )
        {
            $res = array(
                "result"      => true,
                "data" => array(
                    "id"         => $wallet->get( 'id' ),
                    "name"       => $wallet->get( 'name' ),
                    "status"       => $wallet->get( 'status' ),
                    "category"       => $wallet->get( 'category' ),
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