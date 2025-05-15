<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );
    include_once( MODULES_PATH . "wallet.php" );
    include_once( MODULES_PATH . "common.php" );

    if ( isset( $_POST ) && isset( $_POST[ 'fk_user_id' ] ) && isset( $_POST[ 'select_date' ] ) )
    {
        // Define user id & select date
        // $fk_wallet_id = htmlspecialchars( $_POST[ 'fk_wallet_id' ] );
        $fk_user_id = htmlspecialchars( $_POST[ 'fk_user_id' ] );
        $select_date = htmlspecialchars( $_POST[ 'select_date' ] );

        // Setup income, expense, label
        $incomes = array();
        $expenses = array();
        $labels = array();

        // Get default wallet id
        $wallet_controller = new Wallet_Controller();
        $wallet = $wallet_controller->read_default_wallet( $conn, $fk_user_id );

        // Get all finance records
        $finance = new Finance();
        $finance->set( 'fk_wallet_id', $wallet[ 'id' ] );
        $finance->set( 'fk_user_id', $fk_user_id );
        $finance_controller = new Finance_Controller();
        $all_finance = $finance_controller->read_all_by_user_id_and_year( $conn, $finance, $select_date );
        // $all_finance = $crypto->decrypt_all_object( $all_finance );

        $labels = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
        // $current_year = date( 'Y' );
        for ( $i = 1; $i <= 12; $i++ ) 
        {
            $total_income = 0;
            $total_expense = 0;

            // Ensure month is two digits, e.g., '01', '02', ..., '12'
            $m = str_pad($i, 2, '0', STR_PAD_LEFT);

            // If $select_date is a year like '2025', this works
            $year_month = date('Y-m', strtotime("$select_date-$m"));

            foreach ( $all_finance as $finance )
            {
                $finance_year_current_month = date('Y-m', strtotime($finance['date']));
                
                if ($finance_year_current_month === $year_month) {
                    if ($finance['status'] == false) {
                        $total_income += (float) $finance['amount'];
                    } elseif ($finance['status'] == true) {
                        $total_expense += (float) $finance['amount'];
                    }
                }
            }

            $total_income  = Common::convert_two_decimal($total_income);
            $total_expense = Common::convert_two_decimal($total_expense);

            $incomes[]  = $total_income;
            $expenses[] = $total_expense;
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