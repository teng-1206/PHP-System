<?php

    include_once( realpath( dirname( __FILE__ ) . "./../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance.php" );
    include_once( MODULES_PATH . "/finance_category.php" );

    if ( isset( $_POST ) )
    {
        $finance = new Finance();
        $finance->set( 'id', $_POST[ 'id' ] );

        $finance_data_connector = new Finance_Data_Connector();
        $finance = $finance_data_connector->read( $conn, $finance );

        $finance_category = new Finance_Category();
        $finance_category->set( 'id', $finance->get( 'fk_category_id' ) );

        $finance_category_data_connector = new Finance_Category_Data_Connector();
        $finance_category = $finance_category_data_connector->read( $conn, $finance_category );

        if ( ! is_null( $finance ) && ! is_null( $finance_category ) )
        {
            $res = array(
                "result"      => true,
                "data" => array(
                    "id"          => $finance->get( 'id' ),
                    "title"       => $finance->get( 'title' ),
                    "date"        => $finance->get( 'date' ),
                    "status"        => $finance->get( 'status' ),
                    "category_id" => $finance_category->get( 'id' ),
                    "category"    => $finance_category->get( 'category' ),
                    "color_code"  => $finance_category->get( 'color_code' ),
                    "icon_code"   => $finance_category->get( 'icon_code' ),
                    "amount"      => $finance->get( 'amount' ),
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