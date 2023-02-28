<?php

    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "common.php" );
    include_once( MODULES_PATH . "finance.php" );
    include_once( MODULES_PATH . "finance_category.php" );

    if ( isset( $_POST ) )
    {
        $fk_user_id = htmlspecialchars( $_POST[ 'fk_user_id' ] );
        $select_date = htmlspecialchars( $_POST[ 'select_date' ] );

        $finance = new Finance();
        $finance->set( 'fk_user_id', $fk_user_id );

        $finance_controller = new Finance_Controller();
        $all_finance = $finance_controller->read_all_by_user_id( $conn, $finance, $select_date );
        $all_finance = $crypto->decrypt_all_object( $all_finance );

        $finance_category = new Finance_Category();
        $finance_category->set( 'fk_user_id', htmlspecialchars( $_POST[ 'fk_user_id' ] ) );

        $finance_category_controller = new Finance_Category_Controller();
        $all_finance_category = $finance_category_controller->read_all_by_user_id( $conn, $finance_category );
        $all_finance_category = $crypto->decrypt_all_object( $all_finance_category );
        
        $data = array();
        if ( ! is_null( $all_finance_category ) && ! is_null( $all_finance ) )
        {
            foreach ( $all_finance_category as $finance_category )
            {
                $temp_income_total = 0;
                $temp_expense_total = 0;
                foreach ( $all_finance as $finance )
                {
                    $current_year_month = date( 'Y-m' );
                    $finance_year_current_month = date( 'Y-m', strtotime( $finance[ 'date' ] ) );

                    if ( $finance_year_current_month == $current_year_month && $finance_category[ 'id' ] == $finance[ 'fk_category_id' ] ) 
                    {
                        $finance[ 'status' ] ? $temp_expense_total += $finance[ 'amount' ] : $temp_income_total += $finance[ 'amount' ];
                    }
                }
                $temp_income_total = Common::convert_two_decimal( $temp_income_total );
                $temp_expense_total = Common::convert_two_decimal( $temp_expense_total );
                if ( $temp_income_total != '0.00' || $temp_expense_total != '0.00' )
                {
                    $total = array( "income" => $temp_income_total, "expense" => $temp_expense_total );
                    $finance_category = array_merge_recursive( $finance_category, $total );
                    array_push( $data, $finance_category );
                }
            }
            $res = array(
                "result" => true,
                "data" => $data,
            );
            echo json_encode( $res );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }

?>