<?php
    // Include necessary files
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "poop.php" );

    // Check if the request method is POST
    if ( isset( $_POST ) && isset( $_POST[ 'id' ] ) && !empty( $_POST[ 'id' ] )  )
    {
        // Create a new instance of the Poop class
        $poop = new Poop();
        
        // Set the ID attribute of the Poop object using POST data
        $poop->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        // Create a new instance of the Poop_Controller class
        $poop_controller = new Poop_Controller();
        
        // Read the Poop data from the database
        $poop = $poop_controller->read( $conn, $poop );
        
        // Convert the Poop data to the desired format
        $poop = $poop_controller->convert( $poop );
        
        // Delete the Poop data from the database
        $res = $poop_controller->delete( $conn, $poop );

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
