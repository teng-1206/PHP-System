<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . 'task_status.php' );

    if ( isset( $_POST ) )
    {
        $fk_task_project_id = htmlspecialchars( $_POST[ 'fk_task_project_id' ] );

        $task_status = new Task_Status();
        $task_status->set( 'fk_task_project_id', $fk_task_project_id );

        $task_status_controller = new Task_Status_Controller();
        $all_task_status = $task_status_controller->read_all_by_task_project_id( $conn, $task_status );
        $all_task_status = $crypto->decrypt_all_object( $all_task_status );

        if ( ! is_null( $all_task_status ) )
        {
            $res = array(
                "result" => true,
                "data" => $all_task_status,
            );
            echo json_encode( $res );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
    else
    {
        echo json_encode( array( "result" => false ) );
    }
?>