$( document ).ready( () => {

    function login() {
        $('#login-form').addClass('was-validated');
        const e_username = $('#username');
        const e_password = $('#password');
        const v_username = e_username.val().trim() === '';
        const v_password = e_password.val().trim() === '';
        const hasError = v_username || v_password;
        const api_url = $('meta[name="api-url"]').attr('content');
        const login_url = `${api_url}/login.php`;

        if (!hasError) {
            const data = {
                username: e_username.val(),
                password: e_password.val(),
            };
            $('#btn-login').prop('disabled', true); // Optional UX

            $.ajax({
                type: "POST",
                url: login_url,
                data: data,
                success: (response) => {
                    const res = JSON.parse(response);
                    if (res.result === true) {
                        window.location.href = "dashboard";
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Username or Password Wrong'
                        });
                        e_password.val('');
                    }
                },
                error: (xhr) => {
                    let message = 'AJAX Error';
                    if (xhr.responseText) {
                        try {
                            const res = JSON.parse(xhr.responseText);
                            if (res.message) message = res.message;
                        } catch (e) {}
                    }
                    Toast.fire({
                        icon: 'error',
                        title: message
                    });
                },
                complete: () => {
                    $('#btn-login').prop('disabled', false); // Re-enable button
                }
            });
        } else {
            Toast.fire({
                icon: 'error',
                title: 'Login Failed'
            });
        }
    }


    $( '#btn-login' ).click( () => {
        login();
    } );

    $('#username, #password').on('keydown', (e) => {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            login();
        }
    });


} );