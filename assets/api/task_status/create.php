<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task_status.php" );

    if ( isset( $_POST ) )
    {
        $task_status = new Task_Status();
        $task_status->set( 'title', $crypto->encrypt( htmlspecialchars( $_POST[ 'title' ] ) ) );
        $task_status->set( 'fk_task_project_id', htmlspecialchars( $_POST[ 'fk_task_project_id' ] ) );
        $task_status->set( 'fk_order_id', htmlspecialchars( $_POST[ 'fk_order_id' ] ) );

        $task_status_controller = new Task_Status_Controller();
        $task_status_id = $task_status_controller->create( $conn, $task_status );

        if ( isset( $task_status_id ) )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
?>