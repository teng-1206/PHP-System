<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . 'item.php' );

    if ( isset( $_POST[ 'fk_user_id' ] ) )
    {
        $fk_user_id = htmlspecialchars( $_POST[ 'fk_user_id' ] );

        $item = new Item();
        $item->set( 'fk_user_id', $fk_user_id );

        $item_controller = new Item_Controller();
        $all_item = $item_controller->read_all_by_user_id( $conn, $item, $select_date );
        // $all_item = $crypto->decrypt_all_object( $all_item );

        if ( ! is_null( $all_item ) )
        {
            $res = array(
                "result" => true,
                "data" => $all_item,
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