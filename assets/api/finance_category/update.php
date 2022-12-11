<?php

    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance_category.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $finance_category = new Finance_Category();
        $finance_category->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $finance_category_controller = new Finance_Category_Controller();
        $finance_category = $finance_category_controller->read( $conn, $finance_category );
        $finance_category = $crypto->decrypt_object( $finance_category );
        $finance_category = $finance_category_controller->convert( $finance_category );

        $finance_category->set( 'category', $crypto->encrypt( htmlspecialchars( $_POST[ 'category' ] ) ) );
        $finance_category->set( 'color_code', $crypto->encrypt( htmlspecialchars( $_POST[ 'color_code' ] ) ) );
        $finance_category->set( 'background_color_code', $crypto->encrypt( htmlspecialchars( $_POST[ 'background_color_code' ] ) ) );
        $finance_category->set( 'icon_code', $crypto->encrypt( htmlspecialchars( $_POST[ 'icon_code' ] ) ) );
        $res = $finance_category_controller->update( $conn, $finance_category );

        if ( $res )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }

?>