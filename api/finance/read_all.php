<?php
    include_once( realpath( dirname( __FILE__ ) . "./../../config/config.php" ) );
    include_once( MODULES_PATH . 'finance.php' );
    include_once( MODULES_PATH . "/finance_category.php" );

    if ( isset( $_GET ) )
    {
        $finance_data_connector = new Finance_Data_Connector();
        $all_finance = $finance_data_connector->read_all( $conn );

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