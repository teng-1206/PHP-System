<?php
    // Include config.php
    include_once( realpath( dirname( __FILE__ ) . '//..//config/config.php' ) );

    // Include User class
    include_once( MODULES_PATH . 'user.php' );
    include_once( MODULES_PATH . 'wallet.php' );
    include_once( MODULES_PATH . 'finance.php' );
    include_once( MODULES_PATH . 'finance_category.php' );

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include_once( VENDOR_PATH . "PHPMailer/src/PHPMailer.php" );
    include_once( VENDOR_PATH . "PHPMailer/src/SMTP.php" );
    include_once( VENDOR_PATH . "PHPMailer/src/Exception.php" );

    if ( isset( $_POST[ 'username' ] ) && isset( $_POST[ 'password' ] ) ) 
    {
        // Get username & password and escape HTML
        $username = htmlspecialchars( $_POST[ 'username' ] );
        $password = md5( htmlspecialchars( $_POST[ 'password' ] ) );

        // Define user controller
        $user_controller = new User_Controller();
        
        // Random code for verify
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Define user object
        $user = new User();
        $user->set( 'username', $username );
        $user->set( 'email', $username );
        $user->set( 'password', $password );
        $user->set( 'code', $code );
        $user->set( 'verify_timestamp', date('Y-m-d H:i:s', time() + (15 * 60)) );
        
        // Check username
        $user_id = $user_controller->check_username( $conn2, $user );
        if ( $user_id != 0 )
        {
            echo json_encode( array( "result" => false, "message" => "Username Exist" ) );
            die();
        }

        // Create user
        $user_id = $user_controller->create( $conn2, $user );
        if ( is_null( $user_id ) )
        {
            echo json_encode( array( "result" => false, "message" => "Create user failed" ) );
            die();
        }

        // Create wallet
        $wallet = new Wallet();
        $wallet->set( 'name', $crypto->encrypt( 'Cash' ) );
        $wallet->set( 'status', $crypto->encrypt( 'Default' ) );
        $wallet->set( 'category', $crypto->encrypt( 'Cash' ) );
        $wallet->set( 'amount', $crypto->encrypt( '0.00' ) );
        $wallet->set( 'fk_user_id', $user_id );

        $wallet_controller = new Wallet_Controller();
        $wallet_id = $wallet_controller->create( $conn, $wallet );

        if ( is_null( $wallet_id ) )
        {
            echo json_encode( array( "result" => false, "message" => "Create wallet failed" ) );
            die();
        }

        // Create finance category
        $finance_category = new Finance_Category();
        $finance_category->set( 'category', $crypto->encrypt( 'Foods & Drinks' ) );
        $finance_category->set( 'color_code', $crypto->encrypt( '' ) );
        $finance_category->set( 'background_color_code', $crypto->encrypt( '' ) );
        $finance_category->set( 'icon_code', $crypto->encrypt( '' ) );
        $finance_category->set( 'fk_user_id', $user_id );

        $finance_category_controller = new Finance_Category_Controller();
        $finance_category_id = $finance_category_controller->create( $conn, $finance_category );
        if ( is_null( $finance_category_id ) )
        {
            echo json_encode( array( "result" => false, "message" => "Create finance category failed" ) );
            die();
        }

        $finance_category->set( 'category', $crypto->encrypt( 'Parking' ) );
        $finance_category_id = $finance_category_controller->create( $conn, $finance_category );
        if ( is_null( $finance_category_id ) )
        {
            echo json_encode( array( "result" => false, "message" => "Create finance category failed" ) );
            die();
        }
    
        $finance_category->set( 'category', $crypto->encrypt( 'Shopping' ) );
        $finance_category_id = $finance_category_controller->create( $conn, $finance_category );
        if ( is_null( $finance_category_id ) )
        {
            echo json_encode( array( "result" => false, "message" => "Create finance category failed" ) );
            die();
        }

        $finance_category->set( 'category', $crypto->encrypt( 'Transportation' ) );
        $finance_category_id = $finance_category_controller->create( $conn, $finance_category );
        if ( is_null( $finance_category_id ) )
        {
            echo json_encode( array( "result" => false, "message" => "Create finance category failed" ) );
            die();
        }

        $finance_category->set( 'category', $crypto->encrypt( 'Entertainment' ) );
        $finance_category_id = $finance_category_controller->create( $conn, $finance_category );
        if ( is_null( $finance_category_id ) )
        {
            echo json_encode( array( "result" => false, "message" => "Create finance category failed" ) );
            die();
        }

        // Send verified email to user email
        $content = <<<HTML
        <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Verification Code Email</title>
            </head>
            <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;'>
                <div style='max-width: 500px; margin: auto; background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                    <h2 style='color: #333;'>Verification Code</h2>
                    <p>Please use the six-digit code below to verify your account:</p>
                    <div style='font-size: 28px; font-weight: bold; color: #2c3e50; padding: 10px 0;'>$code</div>
                    <p>This code will expire in 15 minutes. If you did not request this, please ignore this email.</p>
                </div>
            </body>
        </html>
        HTML;
        
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
            $mail->addAddress( $user->get( 'email' ), 'NAME');

            $mail->isHTML( true );
            $mail->Subject = 'Verification Code Email';
            $mail->Body    = $content;

            $mail->send();
            $_SESSION[ 'verify_email' ] = $user->get( 'email' );
            echo json_encode( array( "result" => true, "message" => "Email sent successfully" ) );
            die();
        } catch (Exception $e) {
            echo json_encode( array( "result" => false, "message" => 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo ) );
            die();
        }
    }
    else
    {
        // Return JSON
        $respond = array( 
            "result" => false,
            "message" => "Cannot direct access this page"
        );
        echo json_encode( $respond );
    }
?>