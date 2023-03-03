<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task_project.php" );

    if ( isset( $_POST ) )
    {
        $task_project = new Task_Project();
        $task_project->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $task_project_controller = new Task_Project_Controller();
        $task_project = $task_project_controller->read( $conn, $task_project );
        $task_project = $task_project_controller->convert( $task_project );
        $res = $task_project_controller->delete( $conn, $task_project );

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