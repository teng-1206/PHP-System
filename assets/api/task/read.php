<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $task = new Task();
        $task->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $task_controller = new Task_Controller();
        $task = $task_controller->read( $conn, $task );
        $task = $crypto->decrypt_object( $task );
        $task = $task_controller->convert( $task );

        if ( ! is_null( $task ) )
        {
            $res = array(
                "result" => true,
                "data" => array(
                    "id"          => $task->get( 'id' ),
                    "title"       => $task->get( 'title' ),
                    "description"       => $task->get( 'description' ),
                    "due_date"  => $task->get( 'due_date' ),
                    "fk_task_status_id"  => $task->get( 'fk_task_status_id' ),
                    "fk_order_id"  => $task->get( 'fk_order_id' ),
                    "fk_priority_id"  => $task->get( 'fk_priority_id' ),
                    "fk_repeat_period_id"  => $task->get( 'fk_repeat_period_id' ),
                    "fk_reminder_id"  => $task->get( 'fk_reminder_id' ),
                    "create_at"  => $task->get( 'create_at' ),
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