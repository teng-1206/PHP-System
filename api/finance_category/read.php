<?php

    include_once( realpath( dirname( __FILE__ ) . "./../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance_category.php" );

    if ( isset( $_POST ) )
    {
        $finance_category = new Finance_Category();
        $finance_category->set( 'id', $_POST[ 'id' ] );

        $finance_category_data_connector = new Finance_Category_Data_Connector();
        $finance_category = $finance_category_data_connector->read( $conn, $finance_category );

        if ( ! is_null( $finance_category ) )
        {
            $res = array(
                "result"      => true,
                "data" => array(
                    "id"                    => $finance_category->get( 'id' ),
                    "category"              => $finance_category->get( 'category' ),
                    "color_code"            => $finance_category->get( 'color_code' ),
                    "background_color_code" => $finance_category->get( 'background_color_code' ),
                    "icon_code"             => $finance_category->get( 'icon_code' ),
                ),
            );
            echo json_encode( $res );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }

?>