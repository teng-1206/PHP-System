<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );
    include_once( MODULES_PATH . "finance_category.php" );
    include_once( MODULES_PATH . "common.php" );

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include_once( VENDOR_PATH . "PHPMailer/src/PHPMailer.php" );
    include_once( VENDOR_PATH . "PHPMailer/src/SMTP.php" );
    include_once( VENDOR_PATH . "PHPMailer/src/Exception.php" );


    $month = date( "F Y" );
    $total_expenses = 0;
    $total_incomes = 0;
    $categories = array();

    $select_date = htmlspecialchars( "This Month" );
    $fk_wallet_id = htmlspecialchars( 14 );
    $fk_user_id = htmlspecialchars( 1 );

    $finance = new Finance();
    $finance->set( 'fk_wallet_id', $fk_wallet_id );
    $finance->set( 'fk_user_id', $fk_user_id );

    $finance_controller = new Finance_Controller();
    $all_finance = $finance_controller->read_all_by_user_id( $conn, $finance, $select_date );
    // // $all_finance = $crypto->decrypt_all_object( $all_finance );
    
    if ( ! is_null( $all_finance ) )
    {
        $temp_all_finance = array();
        $total_income = 0;
        $total_expense = 0;
        $total_earning = 0;
        foreach ( $all_finance as $finance )
        {
            if ( $finance[ 'status' ] == false ) 
                $total_income += ( float ) $finance[ 'amount' ];

            if ( $finance[ 'status' ] == true ) 
                $total_expense += ( float ) $finance[ 'amount' ];
        }
        $total_earning = $total_income - $total_expense;
        // $total_income  = Common::convert_two_decimal( $total_income );
        // $total_expense = Common::convert_two_decimal( $total_expense );
        // $total_earning = Common::convert_two_decimal( $total_earning );
        // $total_income  = number_format( $total_income, 2, '.', ',' );
        // $total_expense = number_format( $total_expense, 2, '.', ',' );
        // $total_earning = number_format( $total_earning, 2, '.', ',' );

        $total_expenses = $total_expense;
        $total_incomes = $total_income;
    }

    $finance_category = new Finance_Category();
    $finance_category->set( 'fk_user_id', $fk_user_id );

    $finance_category_controller = new Finance_Category_Controller();
    $all_finance_category = $finance_category_controller->read_all_by_user_id( $conn, $finance_category );
    // $all_finance_category = $crypto->decrypt_all_object( $all_finance_category );

    if ( ! is_null( $all_finance_category ) && ! is_null( $all_finance ) )
    {
        foreach ( $all_finance_category as $finance_category )
        {
            $temp_income_total = 0;
            $temp_expense_total = 0;
            foreach ( $all_finance as $finance )
            {
                if ( $finance_category[ 'id' ] == $finance[ 'fk_category_id' ] ) 
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
                array_push( $categories, $finance_category );
            }
        }
    }

    $categoryRows = '';
    foreach ( $categories as $category ) {
        $name    = ( $category[ 'category' ] );
        $income  = number_format( $category[ 'income' ], 2 );
        $expense = number_format( $category[ 'expense' ], 2 );
        $categoryRows .= "
            <tr>
                <td style=\"padding: 10px; border-bottom: 1px solid #eee;\">$name</td>
                <td style=\"padding: 10px; text-align: right; border-bottom: 1px solid #eee;\">RM $income</td>
                <td style=\"padding: 10px; text-align: right; border-bottom: 1px solid #eee;\">RM $expense</td>
            </tr>
        ";
    }
    
    // Total formatted
    $total_incomes = number_format( $total_incomes, 2 );
    $total_expenses = number_format( $total_expenses, 2 );
    $today = date("F j, Y");
    
    $template = file_get_contents( TEMPLATES_PATH . '/email/monthly-report.html');
    $content = str_replace('{{month}}', htmlspecialchars($month), $template);
    $content = str_replace('{{total_incomes}}', htmlspecialchars($total_incomes), $content);
    $content = str_replace('{{total_expenses}}', htmlspecialchars($total_expenses), $content);
    $content = str_replace('{{today}}', htmlspecialchars($today), $content);
    $content = str_replace('{{categoryRows}}', $categoryRows, $content);    

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = SMTP_AUTH;
        $mail->Username   = SMTP_USERNAME; 
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port       = SMTP_PORT;

        $mail->setFrom( SMTP_EMAIL, SMTP_NAME );
        $mail->addAddress('cmdcool3@gmail.com', 'Ng Qi Teng');

        $mail->isHTML( true );
        $mail->Subject = 'Summary of Your Wallet - ' . $month;
        $mail->Body    = $content;

        $mail->send();
        echo json_encode( array( "result" => true, "message" => "Email sent successfully" ) );
    } catch (Exception $e) {
        echo json_encode( array( "result" => false, "message" => 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo ) );
    }

?>