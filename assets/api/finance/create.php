<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );
    include_once( MODULES_PATH . "wallet.php" );

    if ( isset( $_POST ) )
    {
        $finance = new Finance();
        $finance->set( 'title', $crypto->encrypt( htmlspecialchars( $_POST[ 'title' ] ) ) );
        $finance->set( 'date', htmlspecialchars( $_POST[ 'date' ] ) );
        $finance->set( 'status', $crypto->encrypt( htmlspecialchars( $_POST[ 'status' ] ) ) );
        $finance->set( 'fk_category_id', htmlspecialchars( $_POST[ 'fk_category_id' ] ) );
        $finance->set( 'fk_wallet_id', htmlspecialchars( $_POST[ 'fk_wallet_id' ] ) );
        $finance->set( 'fk_user_id', htmlspecialchars( $_POST[ 'fk_user_id' ] ) );
        $finance->set( 'amount', $crypto->encrypt( htmlspecialchars( $_POST[ 'amount' ] ) ) );

        // $total_income  = number_format( $total_income, 2, '.', ',' );

        $finance_controller = new Finance_Controller();
        $finance_id = $finance_controller->create( $conn, $finance );

        if ( isset( $finance_id ) )
        {
            $wallet = new Wallet();
            $wallet->set( 'id', $_POST[ 'fk_wallet_id' ] );
            
            $wallet_data_connector = new Wallet_Data_Connector();
            $wallet = $wallet_data_connector->read( $conn, $wallet );
            $wallet = $wallet_data_connector->convert( $wallet );
            $new_total = ( float ) 0;
            $old_total = ( float ) $crypto->decrypt( $wallet->get( 'amount' ) );
            $amount = ( float ) $_POST[ 'amount' ];
            if ( $_POST[ 'status' ] ) 
            {
                // Outcome
                $new_total = $old_total - $amount;
            }
            else 
            {
                // Income
                $new_total = $old_total + $amount;
            }
            $new_total = number_format( $new_total, 2, '.', ',' );
            $wallet->set( 'amount', $crypto->encrypt( $new_total ) );
            $res = $wallet_data_connector->update( $conn, $wallet );
        }

        if ( isset( $finance_id ) )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
?>