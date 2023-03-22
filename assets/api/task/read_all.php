<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . 'task.php' );

    if ( isset( $_POST ) )
    {
        $fk_task_status_id = htmlspecialchars( $_POST[ 'fk_task_status_id' ] );

        $task = new Task();
        $task->set( 'fk_task_status_id', $fk_task_status_id );

        $task_controller = new Task_Controller();
        $all_task = $task_controller->read_all_by_task_status_id( $conn, $task );
        ! is_null( $all_task ) ? $all_task = $crypto->decrypt_all_object( $all_task ) : null;

        if ( ! is_null( $all_task ) )
        {
            $res = array(
                "result" => true,
                "data" => $all_task,
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