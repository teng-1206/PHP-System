// Button Login Function
$( '#btn-login' ).click( () => {
    $( '#login-form' ).addClass( 'was-validated' );

    const e_username = $( '#username' );
    const e_password = $( '#password' );
    const v_username = e_username.val() == '';
    const v_password = e_password.val() == '';
    const res = v_username || v_password;
    if ( ! res ) {
        const r_password = e_password.val() == 'password';
        if ( r_password ) {
            // window.location.href = 'dashboard.php';
        } else {
            Toast.fire( {
                icon : 'error',
                title: 'Login Failed'
            } );
            e_password.val( '' );
        }
    } else {
        
        Toast.fire( {
            icon : 'error',
            title: 'Login Failed'
        } );
    }
} );