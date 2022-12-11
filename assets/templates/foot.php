<!-- jQuery Start -->
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "jquery/jquery.min.js"; ?>"></script>
<!-- jQuery End -->

<!-- Bootstrap 5 Start -->
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "bootstrap/popper.min.js"; ?>"></script>
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "bootstrap/bootstrap.min.js"; ?>"></script>
<!-- Bootstrap 5 End -->

<!-- Sweet Alert 2 Start -->
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "sweetalert2/sweetalert2.all.min.js"; ?>"></script>
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "sweetalert2/mixin.js"; ?>"></script>
<!-- Sweet Alert 2 End -->

<!-- Font Awesome 5 Start -->
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "font-awesome/js/all.min.js"; ?>"></script>
<!-- Font Awesome 5 End -->

<!-- Loader Start -->
<script src="<?= $config[ 'urls' ][ 'js' ] . "loader.js"; ?>"></script>
<!-- Loader End -->

<!-- Common JS Start -->
<script src="<?= $config[ 'urls' ][ 'js' ] . "custom/common.js"; ?>"></script>
<!-- Common JS End -->

<!-- Perfect Scrollbar Start -->
<script src="<?= $config[ 'urls' ][ 'plugins' ] . "perfect-scrollbar/perfect-scrollbar.min.js"; ?>"></script>
<!-- Perfect Scrollbar End -->

<script src="<?= $config[ 'urls' ][ 'js' ] . "app.js"; ?>"></script>
<script>
    $( document ).ready( function() {
        App.init();
    } );
</script>
<script src="<?=  $config[ 'urls' ][ 'js' ] . "custom.js"; ?>"></script>

<!-- Logout Modal Start -->
<div class="modal fade back-blur-3" id="m-logout" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
        <div class="modal-content p-3 rounded-5">
            <div class="modal-header border-0">
                <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Do you want to log out ?</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn rounded-pill" onclick="close_logout_modal()" style="width: 100px; height: 40px;">Cancel</button>
                <button type="button" class="btn btn-danger rounded-pill" style="width: 100px; height: 40px;" onclick="logout()">Log Out</button>
            </div>
        </div>
    </div>
</div>
<!-- Logout Modal End -->

<!-- Log Out Start -->
<script>
    const api_url = $( 'meta[ name="api-url" ]' ).attr( 'content' );

    function open_logout_modal() {
        $( '#m-logout' ).modal( 'show' );
    }

    function close_logout_modal() {
        $( '#m-logout' ).modal( 'hide' );
    }

    function logout() {
        window.location.href = api_url + 'logout';
    }
</script>
<!-- Log Out End -->