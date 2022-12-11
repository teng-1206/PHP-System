<?php
    if ( ! isset( $_SESSION[ 'user_id' ] ) )
    {
        echo "<script>location.href='" . $config[ 'urls' ][ 'base' ] . "'</script>";
    }
?>