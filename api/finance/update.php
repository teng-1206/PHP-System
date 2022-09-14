<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance.php" );
    include_once( MODULES_PATH . "/wallet.php" );
    include_once( MODULES_PATH . "/common.php" );


    if ( isset( $_POST[ 'id' ] ) )
    {
        $finance = new Finance();
        $finance->set( 'id', $_POST[ 'id' ] );

        $finance_data_connector = new Finance_Data_Connector();
        $finance = $finance_data_connector->read( $conn, $finance );
        $finance = $crypto->decrypt_object( $finance );
        $finance = $finance_data_connector->convert( $finance );

        $wallet = new Wallet();
        $wallet->set( 'id', $finance->get( 'fk_wallet_id' ) );

        $wallet_data_connector = new Wallet_Data_Connector();
        $wallet = $wallet_data_connector->read( $conn, $wallet );
        $wallet = $wallet_data_connector->convert( $wallet );

        $total = ( float ) $crypto->decrypt( $wallet->get( 'amount' ) );
        $old_amount = ( float ) $finance->get( 'amount' );
        $new_amount = ( float ) $_POST[ 'amount' ];

        if ( $finance->get( 'status' ) )
        {
            // Outcome
            $total = $total + $old_amount;
        }
        else 
        {
            // Income
            $total = $total - $old_amount;
        }

        // $finance->get( 'status' ) == 0 ? $total = $total - $old_amount : $total = $total + $old_amount;
        // $_POST->get( 'status' ) == 0 ? $total = $total + $new_amount : $total = $total - $new_amount;

        if ( $_POST[ 'status' ] )
        {
            $total = $total - $new_amount;
        }
        else
        {
            $total = $total + $new_amount;
        }

        $total = Common::convert_two_decimal( $total );
        $wallet->set( 'amount', $crypto->encrypt( $total ) );
        $res = $wallet_data_connector->update( $conn, $wallet );

        $finance->set( 'title', $crypto->encrypt( $_POST[ 'title' ] ) );
        $finance->set( 'date', $crypto->encrypt( $_POST[ 'date' ] ) );
        $finance->set( 'status', $crypto->encrypt( $_POST[ 'status' ] ) );
        $finance->set( 'amount', $crypto->encrypt( $_POST[ 'amount' ] ) );
        $finance->set( 'fk_category_id', $_POST[ 'fk_category_id' ] );
        $res = $finance_data_connector->update( $conn, $finance );

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