<?php
    include_once( realpath( dirname( __FILE__ ) . "./../../config/config.php" ) );
    include_once( MODULES_PATH . "/finance_category.php" );

    if ( isset( $_GET ) )
    {
        $finance_category_data_connector = new Finance_Category_Data_Connector();
        $all_finance_category = $finance_category_data_connector->read_all( $conn );

        if ( ! is_null( $all_finance_category ) )
        {
            $res = array(
                "result" => true,
                "data" => $all_finance_category,
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