<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );
    include_once( MODULES_PATH . "finance_category.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $finance = new Finance();
        $finance->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $finance_controller = new Finance_Controller();
        $finance = $finance_controller->read( $conn, $finance );
        $finance = $crypto->decrypt_object( $finance );
        $finance = $finance_controller->convert( $finance );

        $finance_category = new Finance_Category();
        $finance_category->set( 'id', $finance->get( 'fk_category_id' ) );

        $finance_category_controller = new Finance_Category_Controller();
        $finance_category = $finance_category_controller->read( $conn, $finance_category );
        $finance_category = $crypto->decrypt_object( $finance_category );
        $finance_category = $finance_category_controller->convert( $finance_category );

        if ( ! is_null( $finance ) && ! is_null( $finance_category ) )
        {
            $res = array(
                "result"      => true,
                "data" => array(
                    "id"          => $finance->get( 'id' ),
                    "title"       => $finance->get( 'title' ),
                    "date"        => $finance->get( 'date' ),
                    "status"      => $finance->get( 'status' ),
                    "category_id" => $finance_category->get( 'id' ),
                    "category"    => $finance_category->get( 'category' ),
                    "color_code"  => $finance_category->get( 'color_code' ),
                    "icon_code"   => $finance_category->get( 'icon_code' ),
                    "fk_user_id"  => $finance->get( 'fk_user_id' ),
                    "amount"      => $finance->get( 'amount' ),
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