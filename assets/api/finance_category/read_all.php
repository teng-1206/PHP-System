<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance_category.php" );

    if ( isset( $_POST[ 'fk_user_id' ] ) )
    {
        $finance_category = new Finance_Category();
        $finance_category->set( 'fk_user_id', htmlspecialchars( $_POST[ 'fk_user_id' ] ) );

        $finance_category_controller = new Finance_Category_Controller();
        $all_finance_category = $finance_category_controller->read_all_by_user_id( $conn, $finance_category );
        ! is_null( $all_finance_category ) ? $all_finance_category = $crypto->decrypt_all_object( $all_finance_category ) : null;

        if ( ! is_null( $all_finance_category ) )
        {
            $res = array(
                "result" => true,
                "data" => $all_finance_category,
            );
            echo json_encode( $res );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
    else
    {
        echo json_encode( array( "result" => false ) );
    }


?>