<?php

    class Common
    {

        public static function convert_two_decimal( $value )
        {
            return sprintf( '%0.2f', round( $value, 2 ) );
        }

    }

?>