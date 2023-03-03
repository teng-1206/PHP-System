<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task-project.php" );

    if ( isset( $_POST ) )
    {
        $task_project = new Task_Project();
        $task_project->set( 'title', $crypto->encrypt( htmlspecialchars( $_POST[ 'title' ] ) ) );
        $task_project->set( 'fk_user_id', htmlspecialchars( $_POST[ 'fk_user_id' ] ) );

        $task_project_controller = new Task_Project_Controller();
        $task_project_id = $task_project_controller->create( $conn, $task_project );

        if ( isset( $task_project_id ) )
        {
            echo json_encode( array( "result" => true ) );
        }
        else
        {
            echo json_encode( array( "result" => false ) );
        }
    }
?>