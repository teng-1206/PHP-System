<?php include_once( realpath( dirname( __FILE__ ) . "/config/config.php" ) ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Profile </title>
    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->
    <!-- Custom CSS End -->
</head>
<body class="bg-light">
    <!-- Navbar Start -->
    <?php include_once( TEMPLATES_PATH . 'navbar.php' ); ?>
    <!-- Navbar End -->

    <main class="container">
        <div class="pt-5 mt-5">
            <div class="row justify-content-center">
                <div class="mt-5 col-6 justify-content-center">
                    <div class="card bg-white" style="border-radius: 1rem;" >
                        <div class="card-body p-5" >
                            <form id="profile-form" class="mb-md-5 mt-md-4 pb-3" >
                                <h2 class="fw-bold mb-2 text-uppercase">Profile</h2>
                                <small class="">Please fill in.</small>
                                <div class="row mt-5 mb-4">
                                    <div class="col-12">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="profile-image" id="profile-image" class="form-control" accept="image/*">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label class="form-label">Username</label>
                                        <p class="">John1234</p>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Password</label>
                                        <br />
                                        <button class="btn btn-primary form-control" type="button" data-bs-toggle="modal" data-bs-target="#m-change-password">Change</button>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="John">
                                    </div>
                                    <div class="col-6">
                                        <label for="gender" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="John@mail.com">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="">-- Gender --</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div>
                                <button id="btn-submit" class="btn btn-success px-3" type="button">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Modal Start -->
        <div class="modal fade" id="m-change-password" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="change-password-form">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="m-password" class="form-label">Current Password</label>
                                    <input type="password" id="m-current-password" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="m-password" class="form-label">New Password</label>
                                    <input type="password" id="m-new-password" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="m-password" class="form-label">Confirm Password</label>
                                    <input type="password" id="m-confirm-password" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="m-btn-submit" type="button" class="btn btn-success">Save Change</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Change Password Modal End -->

    </main>

    <!-- Global JS Start -->
    <?php include_once( TEMPLATES_PATH . 'foot.php' ); ?>
    <!-- Global JS End -->

    <!-- Custom JS Start -->
    <!-- Custom JS End -->
</body>
</html>