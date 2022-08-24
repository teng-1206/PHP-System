<?php

    include_once( realpath( dirname( __FILE__ ) . "./../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance_category.php" );

    if ( isset( $_POST ) )
    {
        $finance_category = new Finance_Category();
        $finance_category->set( 'id', $_POST[ 'id' ] );

        $finance_category_data_connector = new Finance_Category_Data_Connector();
        $finance_category = $finance_category_data_connector->read( $conn, $finance_category );
        $res = $finance_category_data_connector->delete( $conn, $finance_category );

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