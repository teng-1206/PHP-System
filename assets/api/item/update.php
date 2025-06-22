<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "item.php" );
    include_once( MODULES_PATH . "common.php" );

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
            // Define placeholder URLs
            $placeholder_image_url = $config[ 'urls' ][ 'uploads' ] . "item/image-placeholder.jpg";
            $placeholder_thumb_url = $config[ 'urls' ][ 'uploads' ] . "item/image-placeholder.jpg"; // same as image in your case

            // Delete existing image if not placeholder
            $existing_image_url = $item->get( 'image_url' );
            $existing_thumb_url = $item->get( 'thumb_image_url' );

            if ( !empty( $existing_image_url ) && $existing_image_url !== $placeholder_image_url ) {
                $existing_image_path = str_replace( $config[ 'urls' ][ 'uploads' ], UPLOADS_PATH, $existing_image_url );
                if ( file_exists( $existing_image_path ) ) {
                    unlink( $existing_image_path );
                }
            }

            if ( !empty( $existing_thumb_url ) && $existing_thumb_url !== $placeholder_thumb_url ) {
                $existing_thumb_path = str_replace( $config[ 'urls' ][ 'uploads' ], UPLOADS_PATH, $existing_thumb_url );
                if ( file_exists( $existing_thumb_path ) ) {
                    unlink( $existing_thumb_path );
                }
            }
            
            $file = $_FILES[ 'image' ];
            $file_name = basename( $file[ 'name' ] );
            $file_path = $config[ 'urls' ][ 'uploads' ] . 'item/' . time() . '_' . $file_name;
            $target_path = UPLOADS_PATH . 'item/' . time() . '_' . $file_name;

            if ( move_uploaded_file( $file[ 'tmp_name' ], $target_path ) ) {
                $item->set( 'image_url', $file_path );
                // echo json_encode(['result' => true, 'message' => 'Image uploaded successfully.']);

                $thumb_file_path = $config[ 'urls' ][ 'uploads' ] . 'item/' . time() . '_thumb_' . $file_name;
                $thumb_target_path = UPLOADS_PATH . 'item/' . time() . '_thumb_' . $file_name;

                if ( Common::create_thumbnail( $target_path, $thumb_target_path, 300 ) ) {
                    $item->set( 'thumb_image_url', $thumb_file_path );

                    // echo json_encode(['result' => true, 'message' => 'Thumbnail image uploaded successfully.']);
                } else {
                    // $response['thumbnail'] = null;
                    // echo json_encode(['result' => false, 'message' => 'Failed to move thumbnail uploaded file.']);

                }
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