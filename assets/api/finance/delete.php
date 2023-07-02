<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );
    include_once( MODULES_PATH . "wallet.php" );


    if ( isset( $_POST ) )
    {
        $finance = new Finance();
        $finance->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $finance_controller = new Finance_Controller();
        $finance = $finance_controller->read( $conn, $finance );
        $finance = $finance_controller->convert( $finance );
        $res = $finance_controller->delete( $conn, $finance );

        if ( $res )
        {
            $wallet = new Wallet();
            $wallet->set( 'id', $finance->get( 'fk_wallet_id' ) );
            
            $wallet_data_connector = new Wallet_Controller();
            $wallet = $wallet_data_connector->read( $conn, $wallet );
            $wallet = $wallet_data_connector->convert( $wallet );
            $new_total = ( float ) 0;
            // $old_total = ( float ) $crypto->decrypt( $wallet->get( 'amount' ) );
            $old_total = ( float ) ( $wallet->get( 'amount' ) );
            // $amount = ( float ) $crypto->decrypt( $finance->get( 'amount' ) );
            $amount = ( float ) ( $finance->get( 'amount' ) );
            // if ( $crypto->decrypt( $finance->get( 'status' ) ) ) 
            if ( ( $finance->get( 'status' ) ) ) 
            {
                // Outcome
                $new_total = $old_total + $amount;
            }
            else 
            {
                // Income
                $new_total = $old_total - $amount;
            }
            $new_total = number_format( $new_total, 2, '.', '' );
            // $wallet->set( 'amount', $crypto->encrypt( $new_total ) );
            $wallet->set( 'amount', ( $new_total ) );
            $res = $wallet_data_connector->update( $conn, $wallet );
        }

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