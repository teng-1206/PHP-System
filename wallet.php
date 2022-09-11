<?php include_once( realpath( dirname( __FILE__ ) . "/config/config.php" ) ); ?>
<?php include_once( TEMPLATES_PATH . 'validation.php' ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Wallet </title>
    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->

    <!-- Checkbox Start -->
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'css' ] . "forms/theme-checkbox-radio.css"; ?> ">
    <!-- Checkbox End -->

    <!-- Data Table Start -->
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'plugins' ] . "table/datatable/datatables.min.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'plugins' ] . "table/datatable/custom_dt_custom.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'plugins' ] . "table/datatable/dt-global_style.css"; ?>">
    <!-- Data Table End -->

    <!-- Custom CSS End -->

    <style>
        .layout-spacing {
            padding-bottom: 25px;
        }
        .widget {
            position: relative;
            padding: 20px;
            border-radius: 1rem;
            border: none;
            background: #0e1726;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            border: none;
            box-shadow: 0 0.1px 0px rgba(0, 0, 0, 0.002), 0 0.2px 0px rgba(0, 0, 0, 0.003), 0 0.4px 0px rgba(0, 0, 0, 0.004), 0 0.6px 0px rgba(0, 0, 0, 0.004), 0 0.9px 0px rgba(0, 0, 0, 0.005), 0 1.2px 0px rgba(0, 0, 0, 0.006), 0 1.8px 0px rgba(0, 0, 0, 0.006), 0 2.6px 0px rgba(0, 0, 0, 0.007), 0 3.9px 0px rgba(0, 0, 0, 0.008), 0 7px 0px rgba(0, 0, 0, 0.01);
        }
        .widget .widget-heading {
            margin-bottom: 15px;
        }
        .widget h5 {
            letter-spacing: 0px;
            font-size: 19px;
            display: block;
            color: #e0e6ed;
            font-weight: 600;
            margin-bottom: 0;
        }
        .widget .widget-content {
            font-size: 14px;
        }
    </style>
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
                                <!-- <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li> -->
                                <li class="breadcrumb-item active" aria-current="page"><span>Wallet</span></li>
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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget">
                            <div class="widget-heading">
                                <button id="btn-add-record" class="btn btn-primary rounded-pill shadow mb-3" style="width: 125px; height: 40px;" onclick="open_create_wallet()">
                                    Add
                                </button>
                            </div>
                            <div class="widget-content">
                                <table id="table-wallet" class="table style-1 dt-table-hover non-hover">
                                    <thead>
                                        <tr>
                                            <th class="checkbox-column dt-no-sorting"> Record no. </th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th class="text-center dt-no-sorting">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wallet Modal Start -->
                <div class="modal fade back-blur-3" id="m-wallet" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 id="modal-header-title" class="modal-title">Add Wallet</h5>
                            </div>
                            <div class="modal-body">
                                <form id="wallet-form">
                                    <input type="hidden" id="m-id" name="m-id" value="">
                                    <input type="hidden" id="m-user-id" name="m-user-id" value="1">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label for="m-title" class="form-label">Name</label>
                                            <input type="text" id="m-name" name="m-name" class="form-control" placeholder="Breakfast.." autocomplete="off" required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="m-amount" class="form-label">Amount</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">RM</span>
                                                <input type="text" id="m-amount" name="m-amount" class="form-control text-end" placeholder="0.00" autocomplete="off" required >
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button id="m-btn-cancel" name="m-btn-cancel" type="button" class="btn rounded-pill" onclick="close_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                <button id="m-btn-submit" name="m-btn-submit" type="submit" class="btn btn-primary rounded-pill" form="wallet-form" style="width: 100px; height: 40px;" onclick="">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Wallet Modal End -->

                <!-- Wallet Delete Modal Start -->
                <div class="modal fade back-blur-3" id="m-wallet-delete" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Confirmation</h5>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <input type="hidden" id="m-id-delete" name="m-id-delete" value="">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label">Do you want to delete this record ?</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn rounded-pill" onclick="close_delete_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                <button type="button" class="btn btn-danger rounded-pill" style="width: 100px; height: 40px;" onclick="delete_wallet()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Wallet Delete Modal End -->
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

    <!-- Data Table Start -->
    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "table/datatable/datatables.min.js"; ?>"></script>
    <!-- Data Table End -->

    <!-- wallet JS Start -->
    <script src="<?= $config[ 'urls' ][ 'js' ] . "wallet.js"; ?>"></script>
    <!-- wallet JS End -->

    <!-- Custom JS End -->
</body>
</html>