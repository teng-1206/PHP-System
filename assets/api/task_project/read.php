<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "task_project.php" );

    if ( isset( $_POST[ 'id' ] ) )
    {
        $task_project = new Task_Project();
        $task_project->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $task_project_controller = new Task_Project_Controller();
        $task_project = $task_project_controller->read( $conn, $task_project );
        $task_project = $crypto->decrypt_object( $task_project );
        $task_project = $task_project_controller->convert( $task_project );

        if ( ! is_null( $task_project ) )
        {
            $res = array(
                "result"      => true,
                "data" => array(
                    "id"          => $task_project->get( 'id' ),
                    "title"       => $task_project->get( 'title' ),
                    "fk_user_id"  => $task_project->get( 'fk_user_id' ),
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