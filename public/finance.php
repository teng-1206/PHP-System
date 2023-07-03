<?php include_once( realpath( dirname( __FILE__ ) . "//assets//config//config.php" ) ); ?>
<?php include_once( TEMPLATES_PATH . 'validation.php' ); ?>
<?php include_once( MODULES_PATH . 'user.php' ); ?>
<?php include_once( MODULES_PATH . 'wallet.php' ); ?>
<?php
    $user_controller = new User_Controller();
    $user = new User();
    $user->set( 'id', $_SESSION[ 'user_id' ] );
    $user = $user_controller->read( $conn2, $user );

    $wallet_controller = new Wallet_Controller();
    $wallet = new Wallet();
    $wallet->set( 'fk_user_id', $_SESSION[ 'user_id' ] );
    // $wallet->set( 'status', $crypto->encrypt( 'Default' ) );
    $wallet->set( 'status', ( 'Default' ) );
    $wallet = $wallet_controller->read_default_wallet( $conn, $wallet );
    // $wallet = $crypto->decrypt_object( $wallet );
    $wallet = $wallet_controller->convert( $wallet );
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

    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'css' ] . "components/custom-list-group.css"; ?>">
    <!-- Data Table End -->

    <!-- Finance CSS Start -->
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'css' ] . "custom/finance.css"; ?> ">
    <!-- Finance CSS End -->


    <style>

        
        /*
        Component Card 4
        */
        .component-card_4 {
        width: auto;
        margin: 0 auto;
        border: none;
        border: 1px solid #1b2e4b;
        border-radius: 8px; }

        .component-card_4:hover {
            background: #1b2e4b;
            /* cursor: pointer; */
        }
        .component-card_4 .card-body {
            padding: 0;
            display: flex; }
        .component-card_4 .user-profile {
            align-self: center;
            padding: 0 25px; }
        .component-card_4 img {
            border-radius: 50%; }
        .component-card_4 .user-info {
            padding: 24px 8px 24px 24px; }
        .component-card_4 .card-user_name {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px; }
        .component-card_4 .card-user_occupation {
            color: #888ea8;
            font-size: 13px; }
        .component-card_4 .card-star_rating span {
            display: inline-block;
            padding: 0px 8px;
            font-size: 15px;
            border-radius: 50px;
            margin-bottom: 22px; }
        .component-card_4 .card-star_rating svg {
            width: 16px;
            vertical-align: bottom; }
        .component-card_4 .card-text {
            color: #bfc9d4;
            font-size: 14px;
            letter-spacing: 1px;
            font-weight: 600;
            line-height: 23px; }
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

        <!--  -->
        <input type="hidden" id="user-id" name="user-id" value="<?= $user->get( 'id' ) ?>">
        <input type="hidden" id="wallet-id" name="wallet-id" value="<?= $wallet->get( 'id' ) ?>">
        
        <!--  -->

        <!-- Content Area Start -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">

                    <div class="col-12 layout-spacing justify-content-center">
                        <button id="btn-add-record" class="btn btn-primary rounded-pill shadow" style="" onclick="open_create_finance()">
                            <i class="fas fa-plus-circle"></i>&nbsp;<span>Record</span>
                        </button>
                        <button id="btn-add-finance-category" class="btn btn-primary rounded-pill shadow" style="" onclick="open_create_finance_category()">
                            <i class="fas fa-plus-circle"></i>&nbsp;<span>Category</span>
                        </button>
                        <button id="btn-add-wallet" class="btn btn-primary rounded-pill shadow" style="" onclick="open_create_wallet()">
                            <i class="fas fa-plus-circle"></i>&nbsp;<span>Wallet</span>
                        </button>
                    </div>

                    <!-- Summary Area START -->
                    <div class="summary-area col-12 col-sm-3 layout-spacing justify-content-center">
                        <div id="" class="widget finance-summary-widget">
                            <div class="widget-heading"><span id="current-wallet-name">Wallet</span>
                                <div class="float-right">
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu left" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(-141px, 19px, 0px); top: 0px; left: 0px;" x-placement="bottom-end">
                                            <a class="dropdown-item" href="javascript:void(open_manage_wallet_modal());">Change</a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="widget-content row">
                                <div class="row mb-3 col-12">
                                    <!-- <div class="col-5 align-self-center">
                                        <span class="icon-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                                        </span>
                                    </div> -->
                                    <div class="col">
                                        <!-- <small class="fw-bold fw-light fst-italic">Incomes</small><br/> -->
                                        <span class="fw-bold text-success">RM <span id="current-wallet-amount">0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="summary-area col-12 col-sm-3 layout-spacing justify-content-center">
                        <div id="" class="widget finance-summary-widget">
                            <div class="widget-heading">Incomes</div>
                            <div class="widget-content row">
                                <div class="row mb-3 col-12">
                                    <!-- <div class="col-5 align-self-center">
                                        <span class="icon-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                                        </span>
                                    </div> -->
                                    <div class="col">
                                        <!-- <small class="fw-bold fw-light fst-italic">Incomes</small><br/> -->
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
                                    <!-- <div class="col-5 align-self-center">
                                        <span class="icon-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                                        </span>
                                    </div> -->
                                    <div class="col">
                                        <!-- <small class="fw-light fw-bold fst-italic">Expenses</small><br/> -->
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
                                    <!-- <div class="col-5 align-self-center">
                                        <span class="icon-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                        </span>
                                    </div> -->
                                    <div class="col">
                                        <!-- <small class="fw-light fw-bold fst-italic">Earnings</small><br/> -->
                                        <span class="fw-bold text-primary">RM <span id="total-earning">0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Summary Area END -->

                    <!-- Table Area START -->
                    <div id="table-area" class="col-12 col-sm-9 layout-spacing">
                        <div class="widget">
                            <div class="widget-heading">
                                Records  ( <span id="select-date-label">This Month</span> )
                                <!-- <button id="btn-add-record" class="btn btn-sm btn-primary rounded-pill shadow mb-3" style="" onclick="open_create_finance()">
                                    <i class="fas fa-plus-circle"></i>
                                </button> -->
                                <div class="float-right">
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu left" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(-141px, 19px, 0px); top: 0px; left: 0px;" x-placement="bottom-end">
                                            <a class="dropdown-item" href="javascript:void( update_select_date( 'This Month' ) );">This Month</a>
                                            <a class="dropdown-item" href="javascript:void( update_select_date( 'This Year' ));">This Year</a>
                                            <a class="dropdown-item" href="javascript:void( update_select_date( 'Last Month' ) )">Last Month</a>
                                            <!-- <a class="dropdown-item" href="javascript:void( update_select_date( 'Last Year' ));">Last Year</a> -->
                                            <a class="dropdown-item" href="javascript:void( update_select_date( 'All' ));">All</a>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="select-date" value="This Month">
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
                    <!-- Table Area START -->

                    <!-- Category Area START -->
                    <div id="category-area" class="col-12 col-sm-3 layout-spacing justify-content-center">
                        <div id="finance-category-summary-widget" class="widget">
                            <div class="widget-heading">Category
                                <div class="float-right">
                                    <div class="dropdown d-inline-block">
                                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu left" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(-141px, 19px, 0px); top: 0px; left: 0px;" x-placement="bottom-end">
                                            <a class="dropdown-item" href="javascript:void(open_manage_finance_category_modal());">Manage</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="finance-category-list" class="widget-content">
                            </div>
                        </div>
                    </div>
                    <!-- Category Area END -->

                </div>

                <!-- Finance Modal Start -->
                <div class="modal fade back-blur-3" id="m-finance-record" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 id="modal-header-title" class="modal-title">Add Record</h5>
                            </div>
                            <div class="modal-body">
                                <form id="finance-record-form">
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="hidden" id="user-id" name="user-id" value="<?= $user->get( 'id' ) ?>">
                                    <div class="row ">
                                        <div class="col-12 mb-4">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" id="title" name="title" class="form-control" placeholder="Breakfast.." autocomplete="off" required />
                                        </div>
                                        
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status" name="status" class="form-control" required >
                                                <option value="" >Select Status</option>
                                                <option value="0">Income</option>
                                                <option value="1" selected>Expense</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="category" class="form-label">Category</label>
                                            <select id="category" name="category" class="form-control" required >
                                                <option value="" selected >Select Category</option>
                                                <?php
                                                    include_once( MODULES_PATH . "finance_category.php" );
                                                    $finance_category_controller = new Finance_Category_Controller();
                                                    $finance_category = new Finance_Category();
                                                    $finance_category->set( 'fk_user_id', $_SESSION[ 'user_id' ] );
                                                    $all_finance_category = $finance_category_controller->read_all_by_user_id( $conn, $finance_category );
                                                    // usort( $all_finance_category, function( $a, $b ) {
                                                    //     return strcmp( $a[ 'name' ], $b[ 'name' ] );
                                                    // } );
                                                    if ( ! is_null( $all_finance_category ) ) :
                                                        foreach ( $all_finance_category as $finance_category ) :
                                                        ?>
                                                            <option value="<?= $finance_category[ 'id' ] ?>">
                                                                <?= '' // $crypto->decrypt( $finance_category[ 'category' ] ) ?>
                                                                <?= $finance_category[ 'category' ] ?>
                                                            </option>
                                                        <?php
                                                        endforeach ;
                                                    endif ;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="amount" class="form-label">Amount</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">RM</span>
                                                <input type="text" id="amount" name="amount" class="form-control text-end" placeholder="0.00" autocomplete="off" required >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <a href="javascript:void($('#expand-option').css('display', 'flex'))">Show More</a> -->
                                    <div id="expand-option" class="row" style="">
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="wallet" class="form-label">Wallet</label>
                                            <select id="wallet-id" name="wallet-id" class="form-control" required >
                                                <option value="" >Select Wallet</option>
                                                <?php
                                                    $all_wallet = $wallet_controller->read_all_by_user_id( $conn, $wallet );
                                                    // $all_wallet = $crypto->decrypt_all_object( $all_wallet );
                                                    // usort( $all_wallet, function( $a, $b ) {
                                                    //     return strcmp( $a[ 'name' ], $b[ 'name' ] );
                                                    // } );
                                                    if ( ! is_null( $all_wallet ) ) :
                                                        foreach ( $all_wallet as $wallet ) :
                                                        ?>
                                                            <option value="<?= $wallet[ 'id' ] ?>" <?= $wallet[ 'status' ] == "Default" ? "selected" : "" ?>>
                                                                <?= $wallet[ 'name' ] ?>
                                                            </option>
                                                        <?php
                                                        endforeach ;
                                                    endif ;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" id="date" name="date" class="form-control" placeholder="DD/MM/YYYY" value="<?= date( 'Y-m-d' ) ?>" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn rounded-pill" onclick="close_finance_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded-pill" form="finance-record-form" style="width: 100px; height: 40px;" onclick="">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Finance Modal End -->

                <!-- Finance Delete Modal Start -->
                <div class="modal fade back-blur-3" id="m-finance-delete-record" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Confirmation</h5>
                            </div>
                            <div class="modal-body">
                                <form id="finance-record-delete-form">
                                    <input type="hidden" id="id" name="id" value="">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label">Do you want to delete this record ?</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn rounded-pill" onclick="close_finance_delete_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                <button type="button" class="btn btn-danger rounded-pill" style="width: 100px; height: 40px;" onclick="delete_finance()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Finance Delete Modal End -->

                <!-- Finance Category Modal Start -->
                <div class="modal fade back-blur-3" id="m-finance-category-record" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 id="modal-header-title" class="modal-title">Add Category</h5>
                            </div>
                            <div class="modal-body">
                                <form id="finance-category-record-form">
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="hidden" id="user-id" name="user-id" value="<?= $user->get( 'id' ) ?>">
                                    <div class="row ">
                                        <div class="col-12 mb-4">
                                            <label for="category" class="form-label">Category</label>
                                            <input type="text" id="category" name="category" class="form-control" placeholder="Foods & Drinks" autocomplete="off" required />
                                        </div>
                                    </div>
                                    <!-- <div class="row mb-4"> -->
                                        <!-- <div class="col-12 form-group"> -->
                                            <!-- <label for="m-icon" class="form-label">Icon</label> -->
                                            <!-- <input type="text" id="m-icon" name="m-icon" class="form-control" placeholder="fas fa-archive" autocomplete="off" required /> -->
                                            <input type="hidden" id="icon" name="icon" class="form-control" placeholder="fas fa-archive" autocomplete="off" required value="a" />
                                        <!-- </div> -->
                                    <!-- </div> -->
                                    <!-- <div class="row mb-4"> -->
                                        <!-- <div class="col-6"> -->
                                            <!-- <label for="m-color" class="form-label">Color</label> -->
                                            <!-- <input type="color" id="m-color" name="m-color" class="form-control form-control-color" autocomplete="off" required /> -->
                                            <input type="hidden" id="color" name="color" class="form-control form-control-color" autocomplete="off" required value="#fff" />
                                        <!-- </div> -->
                                        <!-- <div class="col-6"> -->
                                            <!-- <label for="m-background-color" class="form-label">Background Color</label> -->
                                            <!-- <input type="color" id="m-background-color" name="m-background-color" class="form-control form-control-color" autocomplete="off" required /> -->
                                            <input type="hidden" id="background-color" name="background-color" class="form-control form-control-color" autocomplete="off" required value="#fff" />
                                        <!-- </div> -->
                                    <!-- </div> -->
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn rounded-pill" onclick="cancel_finance_category_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded-pill" form="finance-category-record-form" style="width: 100px; height: 40px;" onclick="">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Finance Category Modal End -->

                <!-- Finance Category Delete Modal Start -->
                <div class="modal fade back-blur-3" id="m-finance-category-delete-record" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Confirmation</h5>
                            </div>
                            <div class="modal-body">
                                <form id="finance-category-record-delete-form">
                                    <input type="hidden" id="id" name="id" value="">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label">Do you want to delete this category ?</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn rounded-pill" onclick="cancel_finance_category_delete_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                <button type="button" class="btn btn-danger rounded-pill" style="width: 100px; height: 40px;" onclick="delete_finance_category()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Finance Category Delete Modal End -->

                <!-- Wallet Modal Start -->
                <div class="modal fade back-blur-3" id="m-wallet-record" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 id="modal-header-title" class="modal-title">Add Wallet</h5>
                            </div>
                            <div class="modal-body">
                                <form id="wallet-record-form">
                                    <input type="hidden" id="id" name="id" value="">
                                    <input type="hidden" id="user-id" name="user-id" value="<?= $user->get( 'id' ) ?>">
                                    <input type="hidden" id="status" name="status" value="Optional">
                                    <div class="row ">
                                        <div class="col-12 mb-4">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Cash" autocomplete="off" required />
                                        </div>
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="category" class="form-label">Category</label>
                                            <select id="category" name="category" class="form-control" required >
                                                <option value="" selected >Select Category</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Bank">Bank</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Debit">Debit</option>
                                                <option value="eWallet">eWallet</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-4">
                                            <label for="amount" class="form-label">Initial Amount</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">RM</span>
                                                <input type="text" id="amount" name="amount" class="form-control text-end" placeholder="0.00" autocomplete="off" required value="0.00" >
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn rounded-pill" onclick="cancel_wallet_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded-pill" form="wallet-record-form" style="width: 100px; height: 40px;" onclick="">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Wallet Modal End -->

                <!-- Wallet Delete Modal Start -->
                <div class="modal fade back-blur-3" id="m-wallet-delete-record" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Confirmation</h5>
                            </div>
                            <div class="modal-body">
                                <form id="wallet-record-delete-form">
                                    <input type="hidden" id="id" name="id" value="">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label">Do you want to delete this wallet ?</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn rounded-pill" onclick="cancel_wallet_delete_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                <button type="button" class="btn btn-danger rounded-pill" style="width: 100px; height: 40px;" onclick="delete_wallet()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Wallet Delete Modal End -->

                <!-- Manage Wallet Modal Start -->
                <div class="modal fade back-blur-3" id="m-manage-wallet" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 id="modal-header-title" class="modal-title">Select Wallet</h5>
                            </div>
                            <div class="modal-body">
                                <form id="manage-wallet-form">
                                    <div class="row ">
                                        <div id="wallet-content-area" class="col-12 mb-4">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn rounded-pill" onclick="close_manage_wallet_modal();" style="width: 100px; height: 40px;">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Manage Wallet Modal End -->

                <!-- Manage Finance Category Modal Start -->
                <div class="modal fade back-blur-3" id="m-manage-finance-category" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                        <div class="modal-content p-3 rounded-5">
                            <div class="modal-header border-0">
                                <h5 id="modal-header-title" class="modal-title">Manage Category</h5>
                            </div>
                            <div class="modal-body">
                                <form id="manage-finance-category-form">
                                    <div class="row ">
                                        <div id="finance-category-content-area" class="col-12 mb-4">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn rounded-pill" onclick="close_manage_finance_category_modal();" style="width: 100px; height: 40px;">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Manage Finance Category Modal End -->

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