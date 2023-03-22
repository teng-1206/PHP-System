<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task.php" );

    if ( isset( $_POST ) )
    {
        // Define New Task
        $new_task = new Task();
        $new_task->set( 'title', $crypto->encrypt( htmlspecialchars( $_POST[ 'title' ] ) ) );
        $new_task->set( 'description', $crypto->encrypt( htmlspecialchars( $_POST[ 'description' ] ) ) );
        isset( $_POST[ 'due_date' ] ) ? $new_task->set( 'due_date', htmlspecialchars( $_POST[ 'due_date' ] ) ) : null;
        $new_task->set( 'fk_task_status_id', htmlspecialchars( $_POST[ 'fk_task_status_id' ] ) );
        $new_task->set( 'fk_order_id', htmlspecialchars( $_POST[ 'fk_order_id' ] ) );
        $new_task->set( 'fk_priority_id', htmlspecialchars( $_POST[ 'fk_priority_id' ] ) );
        $new_task->set( 'fk_repeat_period_id', htmlspecialchars( $_POST[ 'fk_repeat_period_id' ] ) );
        $new_task->set( 'fk_reminder_id', htmlspecialchars( $_POST[ 'fk_reminder_id' ] ) );

        // Define Task Controller
        $task_controller = new Task_Controller();

        // Get all task by task status id and convert into objects
        $all_task = $task_controller->read_all_by_task_status_id( $conn, $new_task );
        $all_task = ! is_null( $all_task ) ? $task_controller->convert_all( $all_task ) : null;
        
        // Update all tasks order id
        foreach ( $all_task as $task )
        {
            $task->set( 'fk_order_id', intval( $task->get( 'fk_order_id' ) ) + 1 );
            $task_controller->update( $conn, $task );
        }

        // Add new task into database
        $task_id = $task_controller->create( $conn, $new_task );

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