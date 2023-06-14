<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "item.php" );


    if ( isset( $_POST[ 'id' ] ) )
    {
        $item = new Item();
        $item->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $item_controller = new Item_Controller();
        $item = $item_controller->read( $conn, $item );
        $item = $crypto->decrypt_object( $item );
        $item = $item_controller->convert( $item );

        $item->set( 'name', $crypto->encrypt( htmlspecialchars( $_POST[ 'name' ] ) ) );
        $item->set( 'description', $crypto->encrypt( htmlspecialchars( $_POST[ 'description' ] ) ) );
        $item->set( 'status',$crypto->encrypt(  htmlspecialchars( $_POST[ 'status' ] ) ) );
        $item->set( 'price', $crypto->encrypt( htmlspecialchars( $_POST[ 'price' ] ) ) );
        $item->set( 'purchase_date', htmlspecialchars( $_POST[ 'purchase_date' ] ) );
        $res = $item_controller->update( $conn, $item );

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