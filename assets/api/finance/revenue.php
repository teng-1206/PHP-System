<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );
    include_once( MODULES_PATH . "common.php" );

    if ( isset( $_POST ) && isset( $_POST[ 'fk_user_id' ] ) && isset( $_POST[ 'choice' ] ) )
    {
        // Define user id & choice
        $user_id = htmlspecialchars( $_POST[ 'fk_user_id' ] );
        $choice = htmlspecialchars( $_POST[ 'choice' ] );

        // Setup income, expense, label
        $incomes = array();
        $expenses = array();
        $labels = array();

        // Get all finance records
        $finance = new Finance();
        $finance->set( 'fk_user_id', $user_id );
        $finance_controller = new Finance_Controller();
        $all_finance = $finance_controller->read_all_by_user_id( $conn, $finance );
        $all_finance = $crypto->decrypt_all_object( $all_finance );

        // 
        switch ( $choice ) 
        {
            case 'weekly':
                $labels = array( 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun' );
                $current_date = date( 'D' ) != 'Mon' ? date( 'Y-m-d', strtotime( 'last Monday' ) ) : date( 'Y-m-d' );
                for ( $i = 1; $i < 8; $i++ ) 
                {
                    $total_income = 0;
                    $total_expense = 0;
                    foreach ( $all_finance as $finance )
                    {
                        $finance_current_date = date( 'Y-m-d', strtotime( $finance[ 'date' ] ) );
                        if ( $finance_current_date == $current_date && $finance[ 'status' ] == false ) 
                            $total_income += ( float ) $finance[ 'amount' ];
                        if ( $finance_current_date == $current_date && $finance[ 'status' ] == true ) 
                            $total_expense += ( float ) $finance[ 'amount' ];
                    }
                    $total_income  = Common::convert_two_decimal( $total_income );
                    $total_expense = Common::convert_two_decimal( $total_expense );
                    array_push( $incomes, $total_income );
                    array_push( $expenses, $total_expense );
                    $current_date = date( 'Y-m-d', strtotime( $current_date . ' +1 day' ) );
                }
                break;
            case 'monthly':
                $current_month = date( 'n' );
                $current_year = date( 'Y' );
                $days = cal_days_in_month( CAL_GREGORIAN, $current_month, $current_year );
                for ( $i = 1; $i < $days + 1; $i++ ) 
                {
                    $current_date = date( 'Y-m-d', strtotime( $current_year . '-' . $current_month . '-' . $i ) );
                    $total_income = 0;
                    $total_expense = 0;
                    foreach ( $all_finance as $finance )
                    {
                        $finance_current_date = date( 'Y-m-d', strtotime( $finance[ 'date' ] ) );
                        if ( $finance_current_date == $current_date && $finance[ 'status' ] == false ) 
                            $total_income += ( float ) $finance[ 'amount' ];
                        if ( $finance_current_date == $current_date && $finance[ 'status' ] == true ) 
                            $total_expense += ( float ) $finance[ 'amount' ];
                    }
                    $total_income  = Common::convert_two_decimal( $total_income );
                    $total_expense = Common::convert_two_decimal( $total_expense );
                    array_push( $incomes, $total_income );
                    array_push( $expenses, $total_expense );
                    array_push( $labels, $i );
                }
                break;
            case 'yearly':
                $labels = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
                $current_year = date( 'Y' );
                for ( $i = 1; $i < 13; $i++ ) 
                {
                    $total_income = 0;
                    $total_expense = 0;
                    $m = ( strlen( ( string ) $i ) > 1 ) ? '0' . $i  : $i ;
                    $year_month = ( $choice == 'yearly' ) ? date( 'Y-m', strtotime( date( 'Y-'. $m ) ) ) : date( 'Y-m', strtotime( date( 'Y-'. $m ) . ' -1 year') );
                    
                    foreach ( $all_finance as $finance )
                    {
                        $finance_year_current_month = date( 'Y-m', strtotime( $finance[ 'date' ] ) );
                        if ( $finance_year_current_month == $year_month && $finance[ 'status' ] == false ) 
                            $total_income += ( float ) $finance[ 'amount' ];
                        if ( $finance_year_current_month == $year_month && $finance[ 'status' ] == true ) 
                            $total_expense += ( float ) $finance[ 'amount' ];
                    }
                    $total_income  = Common::convert_two_decimal( $total_income );
                    $total_expense = Common::convert_two_decimal( $total_expense );
                    array_push( $incomes, $total_income );
                    array_push( $expenses, $total_expense );
                }
                break;
            default:
                $labels = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
                break;
        }
        
        if ( ! is_null( $all_finance ) )
        {
            
            $res = array(
                "result" => true,
                "data" => array(
                    "income" => $incomes,
                    "expense" => $expenses,
                    "label" => $labels
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