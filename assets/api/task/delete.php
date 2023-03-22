<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task.php" );

    if ( isset( $_POST ) )
    {
        $delete_task = new Task();
        $delete_task->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $task_controller = new Task_Controller();
        
        $delete_task = $task_controller->read( $conn, $delete_task );
        $delete_task = $task_controller->convert( $delete_task );


        // Get all task by task status id and convert into objects
        $all_task = $task_controller->read_all_by_task_status_id( $conn, $new_task );
        $all_task = ! is_null( $all_task ) ? $task_controller->convert_all( $all_task ) : null;
        
        // Update all tasks order id
        foreach ( $all_task as $task )
        {
            $found = false;
            if ( ( intval( $delete_task->get( 'fk_order_id' ) ) + 1 ) == intval( $task->get( 'fk_order_id' ) ) )
            {
                $found = true;
                $task->set( 'fk_order_id', intval( $delete_task->get( 'fk_order_id' ) ) );
            }

            if ( $found )
            {
                $task->set( 'fk_order_id', intval( $delete_task->get( 'fk_order_id' ) ) + 1 );
            }
            $task_controller->update( $conn, $task );
        }

        $res = $task_controller->delete( $conn, $delete_task );

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