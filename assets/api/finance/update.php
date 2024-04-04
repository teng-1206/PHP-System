<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );
    include_once( MODULES_PATH . "wallet.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $finance = new Finance();
        $finance->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $finance_controller = new Finance_Controller();
        $finance = $finance_controller->read( $conn, $finance );
        if ( is_null( $finance ) )
        {
            echo json_encode( array( "result" => false, "message" => "Finance record not found" ) );
            die();
        }

        // $finance = $crypto->decrypt_object( $finance );
        if ( is_null( $finance ) )
        {
            echo json_encode( array( "result" => $finance, "message" => "Finance record decrypt error" ) );
            die();
        }

        $finance = $finance_controller->convert( $finance );
        if ( is_null( $finance ) )
        {
            echo json_encode( array( "result" => $finance, "message" => "Finance record convert error" ) );
            die();
        }

        $wallet = new Wallet();
        $wallet->set( 'id', $finance->get( 'fk_wallet_id' ) );

        $wallet_data_connector = new Wallet_Controller();
        $wallet = $wallet_data_connector->read( $conn, $wallet );
        if ( is_null( $wallet ) )
        {
            echo json_encode( array( "result" => $finance, "message" => "Wallet record not found" ) );
            die();
        }
        
        $wallet = $wallet_data_connector->convert( $wallet );
        if ( is_null( $wallet ) )
        {
            echo json_encode( array( "result" => $wallet, "message" => "Wallet record convert error" ) );
            die();
        }

        // $total = ( float ) $crypto->decrypt( $wallet->get( 'amount' ) );
        $total = ( float ) ( $wallet->get( 'amount' ) );
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

        if ( $_POST[ 'fk_wallet_id' ] != $wallet->get( 'id' ) )
        {
            $wallet->set( 'amount', ( $total ) );
            $wallet_res = $wallet_data_connector->update( $conn, $wallet );


            $wallet->set( 'id', $_POST[ 'fk_wallet_id' ] );

            $wallet = $wallet_data_connector->read( $conn, $wallet );
            if ( is_null( $wallet ) )
            {
                echo json_encode( array( "result" => $finance, "message" => "Wallet record not found" ) );
                die();
            }
            
            $wallet = $wallet_data_connector->convert( $wallet );
            if ( is_null( $wallet ) )
            {
                echo json_encode( array( "result" => $wallet, "message" => "Wallet record convert error" ) );
                die();
            }
    
            // $total = ( float ) $crypto->decrypt( $wallet->get( 'amount' ) );
            $total = ( float ) ( $wallet->get( 'amount' ) );
            $new_amount = ( float ) $_POST[ 'amount' ];
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
        $total = number_format( $total, 2, '.', '' );
        // $wallet->set( 'amount', $crypto->encrypt( $total ) );
        $wallet->set( 'amount', ( $total ) );
        $wallet_res = $wallet_data_connector->update( $conn, $wallet );

        // $finance->set( 'title', $crypto->encrypt( htmlspecialchars( $_POST[ 'title' ] ) ) );
        $finance->set( 'title', ( htmlspecialchars( $_POST[ 'title' ] ) ) );
        $finance->set( 'description', ( htmlspecialchars( $_POST[ 'description' ] ) ) );
        $finance->set( 'date', htmlspecialchars( $_POST[ 'date' ] ) );
        // $finance->set( 'status', $crypto->encrypt( htmlspecialchars( $_POST[ 'status' ] ) ) );
        $finance->set( 'status', ( htmlspecialchars( $_POST[ 'status' ] ) ) );
        // $finance->set( 'amount', $crypto->encrypt( number_format( htmlspecialchars( $_POST[ 'amount' ] ) , 2, '.', ',' ) ) );
        $finance->set( 'amount', ( number_format( htmlspecialchars( $_POST[ 'amount' ] ) , 2, '.', '' ) ) );
        $finance->set( 'fk_category_id', htmlspecialchars( $_POST[ 'fk_category_id' ] ) );
        $finance->set( 'fk_wallet_id', htmlspecialchars( $_POST[ 'fk_wallet_id' ] ) );
        $finance_res = $finance_controller->update( $conn, $finance );

        if ( $finance_res )
        {
            echo json_encode( array( "result" => true ) );
            die();
        }
        else
        {
            echo json_encode( array( "result" => false ) );
            die();
        }
    }
?>