<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task_status.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $task_status = new Task_Status();
        $task_status->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $task_status_controller = new Task_Status_Controller();
        $task_status = $task_status_controller->read( $conn, $task_status );
        $task_status = $crypto->decrypt_object( $task_status );
        $task_status = $task_status_controller->convert( $task_status );

        if ( ! is_null( $task_status ) )
        {
            $res = array(
                "result" => true,
                "data" => array(
                    "id"          => $task_status->get( 'id' ),
                    "title"       => $task_status->get( 'title' ),
                    "fk_task_project_id"  => $task_status->get( 'fk_task_project_id' ),
                    "fk_order_id"  => $task_status->get( 'fk_order_id' ),
                ),
            );
            echo json_encode( $res );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
?>