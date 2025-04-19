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

        $item->set( 'name', htmlspecialchars( $_POST[ 'name' ] ) );
        $item->set( 'description', htmlspecialchars( $_POST[ 'description' ] ) );
        $item->set( 'status', htmlspecialchars( $_POST[ 'status' ] ) );
        $item->set( 'amount', number_format( htmlspecialchars( $_POST[ 'amount' ] ), 2, '.', '' ) );
        $item->set( 'purchase_date', htmlspecialchars( $_POST[ 'purchase_date' ] ) );

        if ( $item->get( 'status' ) == "No Available" ) 
        {
            $item->set( 'broken_date', htmlspecialchars( $_POST[ 'broken_date' ] ) );
        }
        else
        {
            $item->set( 'broken_date', NULL );
        }

        // $file_path = $config[ 'urls' ][ 'uploads' ] . "item/image-placeholder.jpg";
        // $item->set( 'image_url', $file_path );

        if ( isset( $_FILES[ 'image' ] ) ) {
            $file = $_FILES[ 'image' ];
            $file_name = basename( $file[ 'name' ] );
            $file_path = $config[ 'urls' ][ 'uploads' ] . 'item/' . time() . '_' . $file_name;
            $target_path = UPLOADS_PATH . 'item/' . time() . '_' . $file_name;

            if ( move_uploaded_file( $file[ 'tmp_name' ], $target_path ) ) {
                $item->set( 'image_url', $file_path );
                // echo json_encode(['result' => true, 'message' => 'Image uploaded successfully.']);
            } 
            else
            {
                // echo json_encode(['result' => false, 'message' => 'Failed to move uploaded file.']);
            }
        }
        else
        {
            // echo json_encode(['result' => false, 'message' => 'No file uploaded.']);
        }

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