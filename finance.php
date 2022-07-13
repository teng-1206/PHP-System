<?php include_once( realpath( dirname( __FILE__ ) . "/config/config.php" ) ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Dashboard </title>
    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'plugins' ] . "data-table/data-tables.min.css"; ?>" />
    <!-- Custom CSS End -->
</head>
<body class="bg-light">
    <!-- Navbar Start -->
    <?php include_once( TEMPLATES_PATH . 'navbar.php' ); ?>
    <!-- Navbar End -->

    <main class="m-5 pt-5">
        <div class="row">
            <div class="col-9 justify-content-center">
                <div class="card bg-white" style="border-radius: 1rem;" >
                    <div class="card-body p-5" >
                        <table id="finance-table" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <a class="text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#m-finance-record" href="#" >Dinner</a> </td>
                                    <td> 01-02-2022 </td>
                                    <td> Food </td>
                                    <td> <span class="badge bg-success text-uppercase p-2">RM 5.00 </span> </td>
                                </tr>
                                <tr>
                                    <td> <a class="text-decoration-none text-primary" href="">Dinner</a> </td>
                                    <td> 01-02-2022 </td>
                                    <td> <span class="badge bg-success text-uppercase" style="background-color: blue !important;"> Food </span> </td>
                                    <td> <span class="badge bg-success text-uppercase p-2">RM 5.00 </span> </td>
                                </tr>
                                <tr>
                                    <td> <a class="text-decoration-none text-primary" href="">Dinner</a> </td>
                                    <td> 01-02-2022 </td>
                                    <td> Food </td>
                                    <td> <span class="badge bg-danger text-uppercase p-2">RM 5.00 </span> </td>
                                </tr>
                                <tr>
                                    <td> <a class="text-decoration-none text-primary" href="">Dinner</a> </td>
                                    <td> 01-02-2022 </td>
                                    <td> Food </td>
                                    <td> <span class="badge bg-success text-uppercase p-2">RM 15.00 </span> </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-3 justify-content-center">
                <div class="card bg-white" style="border-radius: 1rem;" >
                    <div class="card-body p-5" >
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Modal Start -->
    <div class="modal fade" id="m-finance-record" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="finance-record-form">
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
    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "data-table/data-tables.min.js"; ?>"></script>
<script> $('#finance-table').DataTable();</script>
    <!-- Custom JS End -->
</body>
</html>