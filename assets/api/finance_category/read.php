<?php

    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance_category.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $finance_category = new Finance_Category();
        $finance_category->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $finance_category_controller = new Finance_Category_Controller();
        $finance_category = $finance_category_controller->read( $conn, $finance_category );
        // $finance_category = $crypto->decrypt_object( $finance_category );
        $finance_category = $finance_category_controller->convert( $finance_category );

        if ( ! is_null( $finance_category ) )
        {
            $res = array(
                "result"      => true,
                "data" => array(
                    "id"                    => $finance_category->get( 'id' ),
                    "category"              => $finance_category->get( 'category' ),
                    "color_code"            => $finance_category->get( 'color_code' ),
                    "background_color_code" => $finance_category->get( 'background_color_code' ),
                    "icon_code"             => $finance_category->get( 'icon_code' ),
                    "fk_user_id"            => $finance_category->get( 'fk_user_id' ),
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