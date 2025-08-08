$( document ).ready( () => {
    $( '#btn-register' ).click( () => {
        $( '#register-form' ).addClass( 'was-validated' );
        const e_username = $( '#username' );
        const e_password = $( '#password' );
        const e_confirm_password = $( '#confirm-password' );
        const v_username = e_username.val() == '';
        const v_password = e_password.val() == '';
        const v_confirm_password = e_confirm_password.val() == '';
        const res = v_username || v_password || v_confirm_password || ( e_password == e_confirm_password );
        const api_url = $( 'meta[ name="api-url" ]' ).attr( 'content' );
        const register_url = `${ api_url }/register.php`;
        if ( ! res ) {
            var data = {
                username: e_username.val(),
                password: e_password.val(),
            };
            $.ajax( {
                type: "POST",
                url: register_url,
                data: data,
                success: ( res ) => {
                    var res = JSON.parse( res );
                    if( res.result == true ) {
                        window.location.href= "verification";
                    } else {
                        console.log( res );
                        Toast.fire( {
                            icon : 'error',
                            title: res.message,
                        } );
                        e_password.val( '' );
                        e_confirm_password.val( '' );
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
            if ( e_password != e_confirm_password ) {
                Toast.fire( {
                    icon : 'error',
                    title: 'Password not same'
                } );
                e_password.val( '' );
                e_confirm_password.val( '' );
            } else {
                Toast.fire( {
                    icon : 'error',
                    title: 'Register Failed'
                } );
            }
            
        }
        
    } );

} );