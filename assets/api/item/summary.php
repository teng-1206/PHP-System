<?php
    include_once( realpath( dirname( __FILE__ ) . "//..//..//config//config.php" ) );
    include_once( MODULES_PATH . "item.php" );
    include_once( MODULES_PATH . "common.php" );

    if ( isset( $_POST ) )
    {
        if ( isset( $_POST[ 'fk_user_id' ] ) )
        {
            $fk_user_id = htmlspecialchars( $_POST[ 'fk_user_id' ] );

            $item = new Item();
            $item->set( 'fk_user_id', $fk_user_id );

            $item_controller = new Item_Controller();
            $all_item = $item_controller->read_all_by_user_id( $conn, $item );
            // $all_item = $crypto->decrypt_all_object( $all_item );

            if ( ! is_null( $all_item ) )
            {
                $total_value = 0;
                foreach ( $all_item as $item )
                {
                    // if ( $finance[ 'status' ] == false ) 
                    //     $total_income += ( float ) $finance[ 'amount' ];

                    $total_value += ( float ) $item[ 'amount' ];
                }
                $total_value  = number_format( $total_value, 2, '.', ',' );

                $res = array(
                    "result" => true,
                    "data" => array(
                        "total_value" => $total_value,
                    ),
                );
                echo json_encode( $res );
            }
            else
            {
                echo json_encode( array( "result" => false, "message" => "Item not found" ) );
            }
        }
        else
        {
            echo json_encode( array( "result" => false, "message" => "User id not found" ) );
        }

    }
?>