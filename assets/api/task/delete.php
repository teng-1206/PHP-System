<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task.php" );

    if ( isset( $_POST ) )
    {
        $task = new Task();
        $task->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $task_controller = new Task_Controller();
        // $task = $task_controller->read( $conn, $task );
        // $task = $task_controller->convert( $task );
        $res = $task_controller->delete( $conn, $task );

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