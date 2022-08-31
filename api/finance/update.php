<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance.php" );

    if ( isset( $_POST ) )
    {
        $finance = new Finance();
        $finance->set( 'id', $_POST[ 'id' ] );

        $finance_data_connector = new Finance_Data_Connector();
        $finance = $finance_data_connector->read( $conn, $finance );
        $finance = $crypto->decrypt_object( $finance );

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