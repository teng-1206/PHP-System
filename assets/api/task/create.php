<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task.php" );

    if ( isset( $_POST ) )
    {
        $task = new Task();
        $task->set( 'title', $crypto->encrypt( htmlspecialchars( $_POST[ 'title' ] ) ) );
        $task->set( 'description', $crypto->encrypt( htmlspecialchars( $_POST[ 'description' ] ) ) );
        isset( $_POST[ 'due_date' ] ) ? $task->set( 'due_date', htmlspecialchars( $_POST[ 'due_date' ] ) ) : null;
        $task->set( 'fk_task_status_id', htmlspecialchars( $_POST[ 'fk_task_status_id' ] ) );
        $task->set( 'fk_order_id', htmlspecialchars( $_POST[ 'fk_order_id' ] ) );
        $task->set( 'fk_priority_id', htmlspecialchars( $_POST[ 'fk_priority_id' ] ) );
        $task->set( 'fk_repeat_period_id', htmlspecialchars( $_POST[ 'fk_repeat_period_id' ] ) );
        $task->set( 'fk_reminder_id', htmlspecialchars( $_POST[ 'fk_reminder_id' ] ) );

        $task_controller = new Task_Controller();
        $task_id = $task_controller->create( $conn, $task );

        if ( isset( $task_id ) )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
?>