<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . '/finance.php' );
    include_once( MODULES_PATH . '/finance_category.php' );

    if ( isset( $_POST[ 'fk_wallet_id' ] ) )
    {
        $finance = new Finance();
        $finance->set( 'fk_wallet_id', $_POST[ 'fk_wallet_id' ] );

        $finance_data_connector = new Finance_Data_Connector();
        $all_finance = $finance_data_connector->read_all_by_wallet_id( $conn, $finance );
        $all_finance = $crypto->decrypt_all_object( $all_finance );

        if ( ! is_null( $all_finance ) )
        {
            $res = array(
                "result" => true,
                "data" => $all_finance,
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