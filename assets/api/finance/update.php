<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "finance.php" );


    if ( isset( $_POST[ 'id' ] ) )
    {
        $finance = new Finance();
        $finance->set( 'id', htmlspecialchars( $_POST[ 'id' ] ) );

        $finance_controller = new Finance_Controller();
        $finance = $finance_controller->read( $conn, $finance );
        $finance = $crypto->decrypt_object( $finance );
        $finance = $finance_controller->convert( $finance );

        $finance->set( 'title', $crypto->encrypt( htmlspecialchars( $_POST[ 'title' ] ) ) );
        $finance->set( 'date', $crypto->encrypt( htmlspecialchars( $_POST[ 'date' ] ) ) );
        $finance->set( 'status', $crypto->encrypt( htmlspecialchars( $_POST[ 'status' ] ) ) );
        $finance->set( 'amount', $crypto->encrypt( htmlspecialchars( $_POST[ 'amount' ] ) ) );
        $finance->set( 'fk_category_id', htmlspecialchars( $_POST[ 'fk_category_id' ] ) );
        $res = $finance_controller->update( $conn, $finance );

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