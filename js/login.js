$( document ).ready( () => {
    const api_url = $( '#api-url' ).attr( 'content' );
    // Button Login Function
    $( '#btn-login' ).click( () => {
        $( '#login-form' ).addClass( 'was-validated' );
        const e_username = $( '#username' );
        const e_password = $( '#password' );
        const v_username = e_username.val() == '';
        const v_password = e_password.val() == '';
        const res = v_username || v_password;
        if ( ! res ) {
            var data = {
                username: e_username.val(),
                password: e_password.val(),
            };
            $.ajax( {
                type: "POST",
                url: api_url + "login.php",
                data: data,
                success: ( res ) => {
                    var res = JSON.parse( res );
                    if( res.result == true ) {
                        window.location.href= "dashboard.php";
                    } else {
                        Toast.fire( {
                            icon : 'error',
                            title: 'Username or Password Wrong'
                        } );
                        e_password.val( '' );
                    }
                },
                error: () => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'AJAX Error'
                    } );
                }
            } );
        } else {
            Toast.fire( {
                icon : 'error',
                title: 'Login Failed'
            } );
        }
        
    } );

} );