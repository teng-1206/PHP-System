<?php
    // Include necessary files
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "item.php" );

    // Check if the request method is POST
    if ( isset( $_POST ) && isset( $_POST[ 'id' ] ) && !empty( $_POST[ 'id' ] )  )
    {
        // Create a new instance of the Item class
        $item = new Item();
        
        // Set the ID attribute of the Item object using POST data
        $item->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        // Create a new instance of the Item_Controller class
        $item_controller = new Item_Controller();
        
        // Read the Item data from the database
        $item = $item_controller->read( $conn, $item );
        
        // Convert the Item data to the desired format
        $item = $item_controller->convert( $item );
        
        // Delete the Item data from the database
        $res = $item_controller->delete( $conn, $item );

        // Return the result of the operation as JSON
        if ( $res )
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
        echo json_encode( array( "error" => "Invalid ID" ) );
    }
?>
