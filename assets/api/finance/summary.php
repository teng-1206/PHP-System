<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );
    include_once( MODULES_PATH . "common.php" );

    if ( isset( $_POST ) )
    {
        $finance = new Finance();
        $finance->set( 'fk_user_id', htmlspecialchars( $_POST[ 'fk_user_id' ] ) );

        $finance_controller = new Finance_Controller();
        $all_finance = $finance_controller->read_all_by_user_id( $conn, $finance );
        $all_finance = $crypto->decrypt_all_object( $all_finance );
        
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
            $total_income  = Common::convert_two_decimal( $total_income );
            $total_expense = Common::convert_two_decimal( $total_expense );
            $total_earning = Common::convert_two_decimal( $total_earning );
            $total_income  = number_format( $total_income, 2, '.', ',' );
            $total_expense = number_format( $total_expense, 2, '.', ',' );
            $total_earning = number_format( $total_earning, 2, '.', ',' );
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