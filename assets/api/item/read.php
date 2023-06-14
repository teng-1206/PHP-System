<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "item.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $item = new Item();
        $item->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $item_controller = new Item_Controller();
        $item = $item_controller->read( $conn, $item );
        // $item = $crypto->decrypt_object( $item );
        $item = $item_controller->convert( $item );

        if ( ! is_null( $item ) )
        {
            $res = array(
                "result"      => true,
                "data" => array(
                    "id"            => $item->get( 'id' ),
                    "name"          => $item->get( 'name' ),
                    "description"   => $item->get( 'description' ),
                    "status"        => $item->get( 'status' ),
                    "purchase_date" => $item->get( 'purchase_date' ),
                    "fk_user_id"    => $item->get( 'fk_user_id' ),
                ),
            );
            echo json_encode( $res );
        }
        else
        {
            echo json_encode( array( "result" => false, "message" => "Item not found" ) );
        }
    }
    else
    {
        echo json_encode( array( "result" => false, "message" => "Item id missing" ) );
    }
?>