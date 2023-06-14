<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "item.php" );

    if ( isset( $_POST ) && isset( $_POST[ 'fk_user_id' ] ) )
    {
        $item = new Item();
        $item->set( 'name', htmlspecialchars( $_POST[ 'name' ] ) );
        $item->set( 'description', htmlspecialchars( $_POST[ 'description' ] ) );
        $item->set( 'status', htmlspecialchars( $_POST[ 'status' ] ) );
        $item->set( 'price', htmlspecialchars( $_POST[ 'price' ] ) );
        $item->set( 'purchase_date', htmlspecialchars( $_POST[ 'purchase_date' ] ) );
        $item->set( 'fk_user_id', htmlspecialchars( $_POST[ 'fk_user_id' ] ) );

        $item_controller = new Item_Controller();
        $item_id = $item_controller->create( $conn, $item );

        if ( isset( $item_id ) )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
    else
    {
        echo json_encode( array( "result" => false, "message" => "Date field is required" ) );
    }
?>