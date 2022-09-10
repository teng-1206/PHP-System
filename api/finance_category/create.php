<?php

    include_once( realpath( dirname( __FILE__ ) . "/../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance_category.php" );

    if ( isset( $_POST ) )
    {
        $finance_category = new Finance_Category();
        $finance_category->set( 'category', $crypto->encrypt( $_POST[ 'category' ] ) );
        $finance_category->set( 'icon_code', $crypto->encrypt( $_POST[ 'icon_code' ] ) );
        $finance_category->set( 'color_code', $crypto->encrypt( $_POST[ 'color_code' ] ) );
        $finance_category->set( 'background_color_code', $crypto->encrypt( $_POST[ 'background_color_code' ] ) );
        $finance_category->set( 'fk_user_id', $_POST[ 'fk_user_id' ] );

        $finance_category_data_connector = new Finance_Category_Data_Connector();
        $finance_category_id = $finance_category_data_connector->create( $conn, $finance_category );

        if ( isset( $finance_category_id ) )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }

?>