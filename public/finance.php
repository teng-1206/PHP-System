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
    <title> System | Finance </title>
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
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'plugins' ] . "table/datatable/dt-global_style.min.css"; ?>">
    <!-- Data Table End -->

    <!-- Finance CSS Start -->
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'css' ] . "custom/finance.css"; ?> ">
    <!-- Finance CSS End -->

    <style>
        #category-area {
            margin-top: -160px;
        }

        @media only screen and (max-width: 450px) {
            #category-area {
                margin-top: unset;
            }
        }
    </style>

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
                                <li class="breadcrumb-item active" aria-current="page"><span>Finance</span></li>
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
                    <div class="summary-area col-12 col-sm-3 layout-spacing justify-content-center">
                        <div id="" class="widget finance-summary-widget">
                            <div class="widget-heading">Incomes</div>
                            <div class="widget-content row">
                                <div class="row mb-3 col-12">
                                    <div class="col-5 align-self-center">
                                        <span class="icon-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <small class="fw-bold fw-light fst-italic">Incomes</small><br/>
                                        <span class="fw-bold text-success">RM <span id="total-income">0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="summary-area col-12 col-sm-3 layout-spacing justify-content-center">
                        <div id="" class="widget finance-summary-widget">
                            <div class="widget-heading">Expenses</div>
                            <div class="widget-content row">
                                <div class="row mb-3 col-12">
                                    <div class="col-5 align-self-center">
                                        <span class="icon-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <small class="fw-light fw-bold fst-italic">Expenses</small><br/>
                                        <span class="fw-bold text-danger">RM <span id="total-expense">0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="summary-area col-12 col-sm-3 layout-spacing justify-content-center">
                        <div id="" class="widget finance-summary-widget">
                            <div class="widget-heading">Earnings</div>
                            <div class="widget-content row">
                                <div class="row mb-3 col-12">
                                    <div class="col-5 align-self-center">
                                        <span class="icon-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <small class="fw-light fw-bold fst-italic">Earnings</small><br/>
                                        <span class="fw-bold text-primary">RM <span id="total-earning">0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="table-area" class="col-12 col-sm-9 layout-spacing">
                        <div class="widget">
                            <div class="widget-heading">
                                <button id="btn-add-record" class="btn btn-sm btn-primary rounded-pill shadow mb-3" style="" onclick="open_create_finance()">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                            <div class="widget-content">
                                <table id="table-finance" class="table style-1 dt-table-hover non-hover">
                                    <thead>
                                        <tr>
                                            <th class="checkbox-column dt-no-sorting"> Record no. </th>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Category</th>
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
                    <div id="category-area" class="col-12 col-sm-3 layout-spacing justify-content-center">
                        <div id="finance-category-summary-widget" class="widget">
                            <div class="widget-heading">
                                Category
                            </div>
                            <div id="finance-category-list" class="widget-content">
                                <small>No Data Available </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finance Record Modal Start -->
                <div class="modal fade back-blur-3" id="m-finance-record" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 id="modal-header-title" class="modal-title">Add Record</h5>
                            </div>
                            <div class="modal-body">
                                <form id="finance-record-form">
                                    <input type="hidden" id="m-id" name="m-id" value="">
                                    <input type="hidden" id="m-user-id" name="m-user-id" value="<?= $user->get( 'id' ) ?>">
                                    <div class="row ">
                                        <div class="col-12 mb-4">
                                            <label for="m-title" class="form-label">Title</label>
                                            <input type="text" id="m-title" name="m-title" class="form-control" placeholder="Breakfast.." autocomplete="off" required />
                                        </div>
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="m-date" class="form-label">Date</label>
                                            <input type="date" id="m-date" name="m-date" class="form-control" placeholder="DD/MM/YYYY" value="<?= date( 'Y-m-d' ) ?>">
                                        </div>
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="m-status" class="form-label">Status</label>
                                            <select id="m-status" name="m-status" class="form-control" required >
                                                <option value="" selected >Select Status</option>
                                                <option value="0">Income</option>
                                                <option value="1">Expense</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="m-category" class="form-label">Category</label>
                                            <select id="m-category" name="m-category" class="form-control" required >
                                                <option value="" selected >Select Category</option>
                                                <?php
                                                    include_once( MODULES_PATH . "finance_category.php" );
                                                    $finance_category_controller = new Finance_Category_Controller();
                                                    $all_finance_category = $finance_category_controller->read_all( $conn );
                                                    if ( ! is_null( $all_finance_category ) ) :
                                                        foreach ( $all_finance_category as $finance_category ) :
                                                        ?>
                                                            <option value="<?= $finance_category[ 'id' ] ?>">
                                                                <?= $crypto->decrypt( $finance_category[ 'category' ] ) ?>
                                                            </option>
                                                        <?php
                                                        endforeach ;
                                                    endif ;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-4">
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
                                <button id="m-btn-submit" name="m-btn-submit" type="submit" class="btn btn-primary rounded-pill" form="finance-record-form" style="width: 100px; height: 40px;" onclick="">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Finance Record Modal End -->

                <!-- Finance Record Delete Modal Start -->
                <div class="modal fade back-blur-3" id="m-finance-record-delete" tabindex="-1" aria-hidden="true">
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
                                <button type="button" class="btn btn-danger rounded-pill" style="width: 100px; height: 40px;" onclick="delete_finance()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Finance Record Delete Modal End -->
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

    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "blockui/jquery.blockUI.min.js"; ?>"></script>

    <!-- Finance JS Start -->
    <script src="<?= $config[ 'urls' ][ 'js' ] . "custom/finance.js"; ?>"></script>
    <!-- Finance JS End -->

    <!-- Custom JS End -->
</body>
</html>