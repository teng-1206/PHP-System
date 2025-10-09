<?php
    // Include config.php
    include_once( realpath( dirname( __FILE__ ) . '//..//config/config.php' ) );

    // Include User class
    include_once( MODULES_PATH . 'user.php' );

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include_once( VENDOR_PATH . "PHPMailer/src/PHPMailer.php" );
    include_once( VENDOR_PATH . "PHPMailer/src/SMTP.php" );
    include_once( VENDOR_PATH . "PHPMailer/src/Exception.php" );

    if ( isset( $_POST[ 'email' ] ) && isset( $_POST[ 'action' ] ) ) 
    {
        $email = htmlspecialchars( $_POST[ 'email' ] );
        $action = htmlspecialchars( $_POST[ 'action' ] );

        $user_controller = new User_Controller();

        $user = new User();
        $user->set( 'email', $email );
        $user = $user_controller->read_by_email($conn2, $user);

        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->set( 'code', $code );
        $user->set( 'verify_timestamp', date('Y-m-d H:i:s', time() + (15 * 60)) );
        $user_controller->update( $conn2, $user );

        if ( $action == '2fa' ) {

            // Send 2FA email to user email
            $template = file_get_contents( TEMPLATES_PATH . '/email/twofa.html');
            $content = str_replace('{{code}}', htmlspecialchars($code), $template);

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
                $mail->Subject = 'Two-Factor Authentication (2FA) Code';
                $mail->Body    = $content;

                $mail->send();
                setcookie( '2fa_email',  $user->get( 'email' ), time() + 86400 * 30, '/' ); 
                echo json_encode( array( "result" => true, "twofa" => true, "message" => "Email sent successfully" ) );
                die();
            } catch (Exception $e) {
                echo json_encode( array( "result" => false, "twofa" => true, "message" => 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo ) );
                die();
            }
        } 
        else if ( $action == 'verify' ) {
            // Send verified email to user email
            $template = file_get_contents( TEMPLATES_PATH . '/email/verify.html');
            $content = str_replace('{{code}}', htmlspecialchars($code), $template);
            
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
                setcookie( 'verify_email',  $user->get( 'email' ), time() + 86400 * 30, '/' ); 
                echo json_encode( array( "result" => true, "message" => "Email sent successfully" ) );
                die();
            } catch (Exception $e) {
                echo json_encode( array( "result" => false, "message" => 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo ) );
                die();
            }
        }
        else {
            echo json_encode( array( "result" => false, "message" => "Invalid action" ) );
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