<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );

    if ( isset( $_POST ) )
    {
        $finance = new Finance();
        $finance->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $finance_controller = new Finance_Controller();
        $finance = $finance_controller->read( $conn, $finance );
        $finance = $finance_controller->convert( $finance );
        $res = $finance_controller->delete( $conn, $finance );

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