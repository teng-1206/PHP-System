<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . 'task_project.php' );

    if ( isset( $_POST ) )
    {
        $fk_user_id = htmlspecialchars( $_POST[ 'fk_user_id' ] );

        $task_project = new Task_Project();
        $task_project->set( 'fk_user_id', $fk_user_id );

        $task_project_controller = new Task_Project_Controller();
        $all_task_project = $task_project_controller->read_all_by_user_id( $conn, $task_project );
        $all_task_project = $crypto->decrypt_all_object( $all_task_project );

        if ( ! is_null( $all_task_project ) )
        {
            $res = array(
                "result" => true,
                "data" => $all_task_project,
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