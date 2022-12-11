<?php
    if ( ! isset( $_SESSION[ 'user' ] ) )
    {
        echo "<script>location.href='" . $config[ 'urls' ][ 'base' ] . "'</script>";
    }
?>