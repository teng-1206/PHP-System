<?php include_once( realpath( dirname( __FILE__ ) . "//assets//config//config.php" ) ); ?>
<?php include_once( TEMPLATES_PATH . 'validation.php' ); ?>
<?php include_once( MODULES_PATH . 'user.php' ); ?>
<?php
    $user_controller = new User_Controller();
    $user = new User();
    $user->set( 'id', $_SESSION[ 'user_id' ] );
    $user = $user_controller->read( $conn2, $user );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Item </title>

    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->

    <!-- Checkbox Start -->
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'css' ] . "forms/theme-checkbox-radio.css"; ?> ">
    <!-- Checkbox End -->

    <!-- Data Table Start -->
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'plugins' ] . "table/datatable/datatables.min.css"; ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'plugins' ] . "table/datatable/custom_dt_custom.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'plugins' ] . "table/datatable/dt-global_style.min.css"; ?>">
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
                                <li class="breadcrumb-item active" aria-current="page"><span>Item</span></li>
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

        <!--  -->
        <input type="hidden" id="user-id" name="user-id" value="<?= $user->get( 'id' ) ?>">
        <!--  -->

        <!-- Content Area Start -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
                    <div class="col-12 layout-spacing justify-content-center">
                        <button id="btn-add-item" class="btn btn-primary rounded-pill shadow" style="" onclick="open_create_item()">
                            <i class="fas fa-plus-circle"></i>&nbsp;<span>Item</span>
                        </button>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div id="table-area" class="widget">
                            <div class="widget-heading">
                                <h5 class="mb-4">Item</h5>
                            </div>
                            <div class="widget-content">
                                <table id="table-item" class="table style-1 dt-table-hover non-hover">
                                    <thead>
                                        <tr>
                                            <!-- <th class="checkbox-column dt-no-sorting"> Record no. </th> -->
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Days</th>
                                            <th>Price</th>
                                            <th>Purchase Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item Modal Start -->
            <div class="modal fade back-blur-3" id="m-item-record" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                    <div class="modal-content p-3 rounded-5">
                        <div class="modal-header border-0">
                            <h5 id="modal-header-title" class="modal-title">Add Item</h5>
                        </div>
                        <div class="modal-body">
                            <form id="item-record-form">
                                <input type="hidden" id="id" name="id" value="">
                                <input type="hidden" id="user-id" name="user-id" value="<?= $user->get( 'id' ) ?>">
                                <div class="row ">
                                    <div class="col-12 mb-4">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="" autocomplete="off" required />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" id="description" name="description" class="form-control" placeholder="" autocomplete="off" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select id="status" name="status" class="form-control" required >
                                            <option value="" selected>Select Status</option>
                                            <option value="Available">Available</option>
                                            <option value="No Available">No Available</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label for="amount" class="form-label">Amount</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">RM</span>
                                            <input type="text" id="amount" name="amount" class="form-control text-end" placeholder="0.00" autocomplete="off" required >
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label for="purchase-date" class="form-label">Purchase Date</label>
                                        <input type="date" id="purchase-date" name="purchase-date" class="form-control" placeholder="DD/MM/YYYY" value="<?= date( 'Y-m-d' ) ?>" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn rounded-pill" onclick="close_item_modal()" style="width: 100px; height: 40px;">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill" form="item-record-form" style="width: 100px; height: 40px;" onclick="">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Item Modal End -->

            <!-- Item Delete Modal Start -->
            <div class="modal fade back-blur-3" id="m-item-delete-record" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                    <div class="modal-content p-3 rounded-5">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Confirmation</h5>
                        </div>
                        <div class="modal-body">
                            <form id="item-record-delete-form">
                                <input type="hidden" id="id" name="id" value="">
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label">Do you want to delete this record ?</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn rounded-pill" onclick="close_item_delete_modal()" style="width: 100px; height: 40px;">Cancel</button>
                            <button type="button" class="btn btn-danger rounded-pill" style="width: 100px; height: 40px;" onclick="delete_item()">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Item Delete Modal End -->

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

    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "blockui/jquery.blockUI.min.js"; ?>"></script>


    <!-- Item JS Start -->
    <script src="<?= $config[ 'urls' ][ 'js' ] . "custom/item.js"; ?>"></script>
    <!-- Item JS End -->

    <!-- Custom JS End -->
</body>
</html>