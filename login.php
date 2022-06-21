<?php // include_once( realpath( dirname( __FILE__ ) . "/../assets/config/config.php" ) ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap 5 Start -->
    <!-- <link rel="stylesheet" href="./plugins/bootstrap/bootstrap.min.css"> -->
    <!-- Bootstrap 5 End -->

    <!-- Material Bootstrap 5 Start -->
    <link rel="stylesheet" href="./plugins/material-bootstrap/mdb.min.css">
    <!-- Material Bootstrap 5 End -->


    <!-- Sweet Alert 2 Start -->
    <link rel="stylesheet" href="./plugins/sweetalert2/sweetalert2.min.css">
    <!-- Sweet Alert 2 End -->

    <!-- Font Awesome 5 Start -->
    <link rel="stylesheet" href="./plugins/font-awesome/css/all.min.css">
    <!-- Font Awesome 5 End -->

    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>
</head>
<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form id="login-form" class="mb-md-5 mt-md-4 pb-3">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your username and password</p>
                                <div class="form-outline form-white mb-4">
                                    <input type="text" id="username" name="username" class="form-control form-control-lg" autocomplete="off" required />
                                    <label class="form-label" for="username">Username</label>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" autocomplete="off" required />
                                    <label class="form-label" for="password">Password</label>
                                </div>
                            </form>
                            <div>
                                <button id="btn-login" class="btn btn-outline-light btn-lg px-5" type="button">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap 5 Start -->
    <!-- <script src="./plugins/bootstrap/bootstrap.min.js"></script> -->
    <!-- <script src="./plugins/bootstrap/bootstrap.bundle.min.js"></script> -->
    <!-- Bootstrap 5 End -->

    <!-- Material Bootstrap 5 Start -->
    <script src="./plugins/material-bootstrap/mdb.min.js"></script>
    <!-- Material Bootstrap 5 End -->

    <!-- jQuery Start -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- jQuery End -->

    <!-- Sweet Alert 2 Start -->
    <script src="./plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Sweet Alert 2 End -->

    <!-- Font Awesome 5 Start -->
    <script src="./plugins/font-awesome/js/all.min.js"></script>
    <!-- Font Awesome 5 End -->

    <script>
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
                    // window.location.href = 'index.php';
                } else {
                    Swal.fire( {
                        icon : 'error',
                        title: 'Oops...',
                        text : 'Something went wrong!',
                    } );
                    e_password.val( '' );
                }
            }
        } )
    </script>

</body>
</html>