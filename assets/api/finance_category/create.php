<?php

    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance_category.php" );

    if ( isset( $_POST ) )
    {
        $finance_category = new Finance_Category();
        // $finance_category->set( 'category', $crypto->encrypt( htmlspecialchars( $_POST[ 'category' ] ) ) );
        $finance_category->set( 'category', ( htmlspecialchars( $_POST[ 'category' ] ) ) );
        // $finance_category->set( 'icon_code', $crypto->encrypt( htmlspecialchars( $_POST[ 'icon_code' ] ) ) );
        $finance_category->set( 'icon_code', ( htmlspecialchars( $_POST[ 'icon_code' ] ) ) );
        // $finance_category->set( 'color_code', $crypto->encrypt( htmlspecialchars( $_POST[ 'color_code' ] ) ) );
        $finance_category->set( 'color_code', ( htmlspecialchars( $_POST[ 'color_code' ] ) ) );
        // $finance_category->set( 'background_color_code', $crypto->encrypt( htmlspecialchars( $_POST[ 'background_color_code' ] ) ) );
        $finance_category->set( 'background_color_code', ( htmlspecialchars( $_POST[ 'background_color_code' ] ) ) );
        $finance_category->set( 'fk_user_id', htmlspecialchars( $_POST[ 'fk_user_id' ] ) );

        $finance_category_controller = new Finance_Category_Controller();
        $finance_category_id = $finance_category_controller->create( $conn, $finance_category );

        if ( isset( $finance_category_id ) )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }

?>