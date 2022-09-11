<?php

    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance_category.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $finance_category = new Finance_Category();
        $finance_category->set( 'id', $_POST[ 'id' ] );

        $finance_category_data_connector = new Finance_Category_Data_Connector();
        $finance_category = $finance_category_data_connector->read( $conn, $finance_category );
        $finance_category = $crypto->decrypt_object( $finance_category );
        $finance_category = $finance_category_data_connector->convert( $finance_category );

        $finance_category->set( 'category', $crypto->encrypt( $_POST[ 'category' ] ) );
        $finance_category->set( 'color_code', $crypto->encrypt( $_POST[ 'color_code' ] ) );
        $finance_category->set( 'background_color_code', $crypto->encrypt( $_POST[ 'background_color_code' ] ) );
        $finance_category->set( 'icon_code', $crypto->encrypt( $_POST[ 'icon_code' ] ) );
        $res = $finance_category_data_connector->update( $conn, $finance_category );

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