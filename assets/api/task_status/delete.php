<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task_status.php" );

    if ( isset( $_POST ) )
    {
        $task_status = new Task_Status();
        $task_status->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $task_status_controller = new Task_Status_Controller();
        $task_status = $task_status_controller->read( $conn, $task_status );
        $task_status = $task_status_controller->convert( $task_status );
        $res = $task_status_controller->delete( $conn, $task_status );

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