$( document ).ready( () => {

    function verify() {
        $('#verification-form').addClass('was-validated');
        const email            = $('#email').val();
        const code             = $('#code').val();
        const api_url          = $('meta[name="api-url"]').attr('content');
        const verification_url = `${api_url}/verification.php`;
        const data = {
            email,
            code
        };
        $('#btn-verify').prop('disabled', true);

        $.ajax({
            type: "POST",
            url: verification_url,
            data: data,
            success: (response) => {
                const res = JSON.parse(response);
                if (res.result === true) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Verification successful! Redirecting to dashboard in 5 seconds...'
                    });

                    setTimeout(() => {
                        window.location.href = "dashboard";
                    }, 5000);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: res.message
                    });
                    $('#code').val( '' );
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
                $('#btn-verify').prop('disabled', false); // Re-enable button
            }
        });
    }

    function resend() {
        const email      = $('#email').val();
        const api_url    = $('meta[name="api-url"]').attr('content');
        const resend_url = `${api_url}/resend.php`;

        const data = {
            email
        }

        $('#btn-resend').prop('disabled', true);
        $('#btn-resend').text('Resending...');

        $.ajax({
            type: "POST",
            url: resend_url,
            data: data,
            success: (response) => {
                const res = JSON.parse(response);
                if (res.result === true) {
                    Toast.fire({
                        icon: 'success',
                        title: res.message
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: res.message
                    });
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
                $('#btn-resend').prop('disabled', false);
                $('#btn-resend').text('Resend Code');
            }
        });
    }

    $( '#btn-verify' ).click( () => {
        verify();
    } );

    $('#code').on('keydown', (e) => {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            verify();
        }
    });

    $( '#btn-resend' ).click( () => {
        resend();
    } );


} );