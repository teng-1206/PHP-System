<?php

    include_once( realpath( dirname( __FILE__ ) . "./../../config/config.php" ) );
    include_once( MODULES_PATH . "/common.php" );
    include_once( MODULES_PATH . "/finance.php" );

    if ( isset( $_GET ) )
    {
        $finance_data_connector = new Finance_Data_Connector();
        $all_finance = $finance_data_connector->read_all( $conn );
        if ( ! is_null( $all_finance ) )
        {
            $temp_all_finance = array();
            $total_income = 0;
            $total_expense = 0;
            $total_earning = 0;
            foreach ( $all_finance as $finance )
            {
                $current_year_month = date( 'Y-m' );
                $finance_year_current_month = date( 'Y-m', strtotime( $finance[ 'date' ] ) );
                if ( $finance_year_current_month == $current_year_month && $finance[ 'status' ] == false ) 
                    $total_income += ( float ) $finance[ 'amount' ];

                if ( $finance_year_current_month == $current_year_month && $finance[ 'status' ] == true ) 
                    $total_expense += ( float ) $finance[ 'amount' ];
            }
            $total_earning = $total_income - $total_expense;
            $total_income = Common::convert_two_decimal( $total_income );
            $total_expense = Common::convert_two_decimal( $total_expense );
            $total_earning = Common::convert_two_decimal( $total_earning );
            $res = array(
                "result" => true,
                "data" => array( 
                    "total_income" => $total_income,
                    "total_expense" => $total_expense,
                    "total_earning" => $total_earning,
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