<?php include_once( realpath( dirname( __FILE__ ) . "//assets//config//config.php" ) ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta id="api-url" name="api-url" content="<?= $config[ 'urls' ][ 'api' ] ?>" />

    <link rel="icon" type="image/x-icon" sizes="32x32" href="<?= $config[ 'urls' ][ 'img' ] . "icon.ico"; ?>" />
    
    <title> System | Register </title>

    <!-- Global CSS Start -->
    <!-- Material Bootstrap 5 Start -->
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'plugins' ] . "material-bootstrap/mdb.min.css"; ?>" />
    <!-- Material Bootstrap 5 End -->

    <!-- Sweet Alert 2 Start -->
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'plugins' ] . "sweetalert2/sweetalert2.min.css"; ?>" />
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'plugins' ] . "sweetalert2/mixin.css"; ?>" />
    <!-- Sweet Alert 2 End -->

    <!-- Font Awesome 5 Start -->
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'plugins' ] . "font-awesome/css/all.min.css"; ?>" />
    <!-- Font Awesome 5 End -->
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'css' ] . "custom/login.css"; ?>" />
    <!-- Custom CSS End -->

</head>
<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form id="register-form" class="mb-md-5 mt-md-4 pb-3">
                                <img class="mb-3" src="<?= $config[ 'urls' ][ 'img' ] . "icon-128x128.png"; ?>" height="100px" width="100px" alt="Icon">
                                <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                                <p class="text-white-50 mb-5">Please fill in</p>
                                <div class="form-outline form-white mb-4">
                                    <input type="email" id="username" name="username" class="form-control form-control-lg" autocomplete="off" required />
                                    <label class="form-label" for="username">Email</label>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" autocomplete="off" required />
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="confirm-password" name="confirm-password" class="form-control form-control-lg" autocomplete="off" required />
                                    <label class="form-label" for="confirm-password">Confirm Password</label>
                                </div>
                            </form>
                            <div>
                                <button id="btn-register" class="btn btn-outline-light btn-lg px-5" type="button">Register</button>
                            </div>
                            <hr>
                            <div>
                                <button id="btn-back" class="btn btn-outline-light btn-lg px-5" type="button" onclick="window.location.href='login'">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Material Bootstrap 5 Start -->
    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "material-bootstrap/mdb.min.js"; ?>"></script>
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

    <!-- Custom JS Start -->
    <script src="<?= $config[ 'urls' ][ 'js' ] . "custom/register.js"; ?>"></script>
    <!-- Custom JS End -->

</body>
</html>