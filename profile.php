<?php include_once( realpath( dirname( __FILE__ ) . "//assets//config//config.php" ) ); ?>
<?php include_once( TEMPLATES_PATH . 'validation.php' ); ?>
<?php include_once( MODULES_PATH . 'user.php' ); ?>
<?php include_once( MODULES_PATH . 'user_profile.php' ); ?>
<?php
    $user_controller = new User_Controller();
    $user = new User();
    $user->set( 'id', $_SESSION[ 'user_id' ] );
    $user = $user_controller->read( $conn2, $user );

    // $user_profile_controller = new User_Profile_Controller();
    // $user_profile = new User_Profile();
    // $user_profile->set( 'fk_user_id', $_SESSION[ 'user_id' ] );
    // $user_profile = $user_profile_controller->read( $conn, $user_profile );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Profile </title>
    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->
    <link href="<?= $config[ 'urls' ][ 'css' ] . "forms/switches.css"; ?>" rel="stylesheet" type="text/css" />
    <!-- Custom CSS End -->
</head>
<body>
    <!-- Loader Start -->
    <?php include_once( TEMPLATES_PATH . 'loader.php' ); ?>
    <!-- Loader End -->

    <!-- Navbar Start -->
    <?php include_once( TEMPLATES_PATH . 'navbar.php' ); ?>
    <!-- Navbar End -->

    <!-- Breadcrumb Start -->
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><span>Profile</span></li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!-- Breadcrumb End -->

    <!-- Main Container Start -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!-- Sidebar Start  -->
        <?php include_once( TEMPLATES_PATH . 'sidebar.php' ); ?>
        <!-- Sidebar End  -->

        <!-- Content Area Start -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
                    <div class="col-12 col-sm-6">
                        <div class="card" style="border-radius: 1rem;" >
                            <div class="card-body p-5" >
                                <form id="profile-form" class="mb-md-5 pb-3" >
                                    <input type="hidden" id="m-user-id" name="m-user-id" value="<?= $user->get( 'id' ) ?>">
                                    <h2 class="fw-bold mb-2">Profile</h2>
                                    <small class="">Please fill in.</small>
                                    <div class="row mt-5 mb-4">
                                        <!-- <div class="col-12 mb-4">
                                            <label class="form-label">Image</label>
                                            <input type="file" name="profile-image" id="profile-image" class="form-control" accept="image/*">
                                        </div> -->
                                        <div class="col-12 col-sm-12 col-md-6 mb-4">
                                            <label class="form-label">Username</label>
                                            <?php
                                            // if ($user->get( 'verify' ) == 0) {
                                            //     echo '<span class="badge badge-warning">Not Verified</span>';
                                            // } else {
                                            //     echo '<span class="badge badge-success">Verified</span>';
                                            // }
                                            ?>
                                            <p class=""><?= $user->get( 'username' ) ?></p>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-4">
                                            <label class="form-label">Password</label>
                                            <br />
                                            <button class="btn btn-primary form-control" type="button" onclick="open_change_password_modal()">Change</button>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-4">
                                            <label class="form-label">Two Factor Authenticator</label>
                                            <br />
                                            <label class="switch s-icons s-outline s-outline-primary mr-2">
                                                <input name="twofa" id="twofa" type="checkbox" <?= $user->get( 'twofa' ) ? 'checked' : '' ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>

                                        
                                        <!-- <div class="col-12 col-sm-6 mb-4">
                                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="John" value="">
                                        </div>
                                        <div class="col-12 col-sm-6 mb-4">
                                            <label for="gender" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="John@mail.com" value="<?= $user->get( 'email' ) ?>">
                                        </div> -->
                                        <!-- <div class="col-12 col-sm-4 mb-4">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select id="gender" name="gender" class="form-control">
                                                <option value="">-- Gender --</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div> -->
                                    </div>
                                </form>
                                <!-- <div> -->
                                    <!-- <button id="btn-submit" class="btn btn-success px-3" type="button">Save Changes</button> -->
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Change Password Modal Start -->
                <div class="modal fade back-blur-3" id="m-change-password" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 id="modal-header-title" class="modal-title">Change Password</h5>
                            </div>
                            <div class="modal-body">
                                <form id="change-password-form">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label for="m-password" class="form-label">Current Password</label>
                                            <input type="password" id="m-current-password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label for="m-password" class="form-label">New Password</label>
                                            <input type="password" id="m-new-password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label for="m-password" class="form-label">Confirm Password</label>
                                            <input type="password" id="m-confirm-password" class="form-control" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button id="m-btn-cancel" name="m-btn-cancel" type="button" class="btn rounded-pill" onclick="close_change_password_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                <button id="m-btn-submit" name="m-btn-submit" type="submit" class="btn btn-primary rounded-pill" form="change-password-form" style="width: 150px; height: 40px;" onclick="">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Change Password Modal End -->
            </div>

            <!-- Footer Start -->
            <?php include_once( TEMPLATES_PATH . 'footer.php' ); ?>
            <!-- Footer End -->
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- Main Container End -->

    <!-- Global JS Start -->
    <?php include_once( TEMPLATES_PATH . 'foot.php' ); ?>
    <!-- Global JS End -->

    <!-- Custom JS Start -->
    <!-- MD5 End -->
    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "md5/md5.js"; ?>"></script>
    <!-- MD5 End -->

    <script>
        function open_change_password_modal() {
            reset_change_password_modal();
            $( '#m-change-password' ).modal( 'show' );
        }

        function close_change_password_modal() {
            reset_change_password_modal();
            $( '#m-change-password' ).modal( 'hide' );
        }

        function reset_change_password_modal() {
            $( '#m-current-password' ).val( null );
            $( '#m-new-password' ).val( null );
            $( '#m-confirm-password' ).val( null );
        }

        $('#change-password-form').submit((event) => {
            event.preventDefault();
            password_validation();
        });

        function password_validation() {
            const user_id        = $('#m-user-id').val();
            const current_password = $('#m-current-password').val();
            const new_password     = $('#m-new-password').val();
            const confirm_password = $('#m-confirm-password').val();

            if (current_password === new_password) {
                reset_change_password_modal();
                return Toast.fire({ icon: 'error', title: 'New Password Cannot Same With Old Password' });
            }
            if (new_password !== confirm_password) {
                reset_change_password_modal();
                return Toast.fire({ icon: 'error', title: 'New Password Not Same With Confirm Password' });
            }

            $.ajax({
                type: 'POST',
                url: `${api_url}profile/validate_password.php`,
                dataType: 'JSON',
                data: { user_id, password: calcMD5(current_password) },
                success: (res) => {
                    if (res.result) {
                        update_password();
                    } else {
                        Toast.fire({ icon: 'error', title: 'Current Password Not Correct' });
                        reset_change_password_modal();
                    }
                },
                error: () => {
                    Toast.fire({ icon: 'error', title: 'Unable to validate password' });
                }
            });
        }

        function update_password() {
            const update_url = `${api_url}profile/update_password.php`;
            const user_id = $('#m-user-id').val();
            const password = $('#m-new-password').val();

            $.ajax({
                type: 'POST',
                url: update_url,
                dataType: 'JSON',
                data: { user_id, password: calcMD5(password) },
                success: (res) => {
                    if (res.result) {
                        close_change_password_modal();
                        Toast.fire({ icon: 'success', title: 'Password changed successfully' });
                    } else {
                        Toast.fire({ icon: 'error', title: 'Password update failed' });
                    }
                },
                error: () => {
                    Toast.fire({ icon: 'error', title: 'Change Password Error' });
                }
            });
        }


        $( '#twofa' ).change( function() {
            const update_url = `${ api_url }profile/update_twofa.php`;
            const user_id  = $( '#m-user-id' ).val();
            const twofa    = $( '#twofa' ).is( ':checked' ) ? 1 : 0;
            const sent_data = { user_id, twofa };
            $.ajax( {
                type    : 'POST',
                url     : update_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        Toast.fire( {
                            icon : 'success',
                            title: 'Update Two Factor Authenticator Success'
                        } );
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Update Two Factor Authenticator Error'
                    } );
                }
            } );
        } );
    </script>
    <!-- Custom JS End -->
</body>
</html>