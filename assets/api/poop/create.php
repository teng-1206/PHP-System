<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "poop.php" );

    if ( isset( $_POST ) && isset( $_POST['date'] ) && isset( $_POST['fk_user_id'] ) )
    {
        $poop = new Poop();
        $poop->set( 'date', htmlspecialchars( $_POST[ 'date' ] ) );
        $poop->set( 'fk_user_id', htmlspecialchars( $_POST[ 'fk_user_id' ] ) );

        $poop_controller = new Poop_Controller();
        $poop_id = $poop_controller->create( $conn, $poop );

        if ( isset( $poop_id ) )
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