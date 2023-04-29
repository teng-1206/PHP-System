<?php
    // Include config.php
    include_once( realpath( dirname( __FILE__ ) . '//..//config/config.php' ) );

    // Include User class
    include_once( MODULES_PATH . 'user.php' );
    include_once( MODULES_PATH . 'wallet.php' );
    include_once( MODULES_PATH . 'finance.php' );
    include_once( MODULES_PATH . 'finance_category.php' );

    if ( isset( $_POST[ 'username' ] ) && isset( $_POST[ 'password' ] ) ) 
    {
        // Get username & password and escape HTML
        $username = htmlspecialchars( $_POST[ 'username' ] );
        $password = md5( htmlspecialchars( $_POST[ 'password' ] ) );

        // Define user controller
        $user_controller = new User_Controller();

        // Define user object
        $user = new User();
        $user->set( 'username', $username );
        $user->set( 'email', $username );
        $user->set( 'password', $password );
        
        $user_id = $user_controller->check_username( $conn2, $user );
        if ( $user_id != 0 )
        {
            echo json_encode( array( "result" => false, "message" => "Username Exist" ) );
            die();
        }

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










        // Check username exist or not

        // Create user

        // Create verified record

        // Send verified email to user email

        // Redirect to check email page

        // Return response

        // Return JSON
        $respond = array(
            "result" => true
        );
        echo json_encode( $respond );
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