<?php

    include_once( realpath( dirname( __FILE__ ) . "./../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance.php" );

    if ( isset( $_POST ) )
    {
        $finance = new Finance();
        $finance->set( 'title', $_POST[ 'title' ] );
        $finance->set( 'date', $_POST[ 'date' ] );
        $finance->set( 'fk_category_id', $_POST[ 'fk_category_id' ] );
        $finance->set( 'amount', $_POST[ 'amount' ] );

        $finance_data_connector = new Finance_Data_Connector();
        $finance_id = $finance_data_connector->create( $conn, $finance );

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