<?php
    // Check if user_id exists in session or cookie
    $user_id = $_SESSION['user_id'] ?? ($_COOKIE['user_id'] ?? null);

    if ($user_id) {
        // Store cookie user_id into session if missing
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = (int) $user_id;
        }

        // If already logged in but on login page → redirect to dashboard
        if ( $current_page == 'login.php' ) {
            header("Location: {$config[ 'urls' ][ 'base' ]}dashboard");
            exit;
        }
    } else {
        // If no session/cookie and not on login page → redirect to login
        if ( $current_page != 'login.php') {
            header("Location: {$config[ 'urls' ][ 'base' ]}login");
            exit;
        }
    }

    // Verification page access restriction
    if ($current_page == 'verification.php' && !isset( $_SESSION[ 'verify_email' ] ) ) {
        header("Location: {$config[ 'urls' ][ 'base' ]}login");
        exit;
    }
?>