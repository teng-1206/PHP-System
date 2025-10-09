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
            $content = <<<HTML
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Two-Factor Authentication (2FA) Code</title>
            </head>
            <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;'>
                <div style='max-width: 500px; margin: auto; background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                    <h2 style='color: #333;'>2FA Verification Code</h2>
                    <p>To complete your login, please enter the following verification code:</p>
                    <div style='font-size: 28px; font-weight: bold; color: #2c3e50; padding: 10px 0;'>$code</div>
                    <p>This code is valid for <strong>15 minutes</strong>. Do not share it with anyone — even if they claim to be from our support team.</p>
                    <p>If you did not attempt to log in, please secure your account immediately.</p>
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