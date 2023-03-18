<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . 'poop.php' );

    if ( isset( $_POST[ 'fk_user_id' ] ) && isset( $_POST[ 'select_date' ] ) )
    {
        $select_date = htmlspecialchars( $_POST[ 'select_date' ] );
        $fk_user_id = htmlspecialchars( $_POST[ 'fk_user_id' ] );

        $poop = new Poop();
        $poop->set( 'fk_user_id', $fk_user_id );

        $poop_controller = new Poop_Controller();
        $all_poop = $poop_controller->read_all_by_user_id( $conn, $poop, $select_date );
        $all_poop = $crypto->decrypt_all_object( $all_poop );

        if ( ! is_null( $all_poop ) )
        {
            $res = array(
                "result" => true,
                "data" => $all_poop,
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