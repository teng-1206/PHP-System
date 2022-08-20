<!-- Bootstrap 5 Start -->
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "bootstrap/bootstrap.min.js"; ?>"></script>
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "bootstrap/bootstrap.bundle.min.js"; ?>"></script>
<!-- Bootstrap 5 End -->

<!-- Material Bootstrap 5 Start -->
<!-- <script src="<?= '' // $config[ 'urls' ][ 'plugins' ] . "material-bootstrap/mdb.min.js"; ?>"></script> -->
<!-- Material Bootstrap 5 End -->

<!-- jQuery Start -->
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "jquery/jquery.min.js"; ?>"></script>
<!-- jQuery End -->

<!-- Sweet Alert 2 Start -->
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "sweetalert2/sweetalert2.all.min.js"; ?>"></script>
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "sweetalert2/mixin.js"; ?>"></script>
<!-- Sweet Alert 2 End -->

<!-- Font Awesome 5 Start -->
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "font-awesome/js/all.min.js"; ?>"></script>
<!-- Font Awesome 5 End -->

<script>
    const api_url = $( 'meta[ name="api-url" ]' ).attr( 'content' );
    $( document ).ready( () => {
        const api_url = $( '#api-url' ).attr( 'content' );

        // Logout Button
        $( '#btn-logout' ).click( () => {
            Swal.fire( {
                title             : 'Logout?',
                icon              : 'question',
                showCancelButton  : true,
                confirmButtonText : 'Log Out',
                denyButtonText    : 'Cancel',
                confirmButtonColor: '#dc3545',
                reverseButtons    : true,
            } ).then( ( result ) => {
                if ( result.isConfirmed ) {
                    window.location.href = api_url + 'logout.php';
                }
            } );
        } );
    } );
</script>