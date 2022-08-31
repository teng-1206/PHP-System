<?php
    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance.php" );

    if ( isset( $_POST ) )
    {
        $finance = new Finance();
        $finance->set( 'id', $_POST[ 'id' ] );

        $finance_data_connector = new Finance_Data_Connector();
        $finance = $finance_data_connector->read( $conn, $finance );
        $res = $finance_data_connector->delete( $conn, $finance );

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