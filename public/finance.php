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
                    <div id="table-area" class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget">
                            <div class="widget-heading">
                                <button id="btn-add-record" class="btn btn-primary rounded-pill shadow mb-3" style="width: 125px; height: 40px;" onclick="open_create_finance()">
                                    <i class="fas fa-plus-circle"></i> Add
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
                    <div id="category-area" class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing justify-content-center">
                        <div id="finance-category-summary-widget" class="widget">
                            <div class="widget-heading">
                                Category
                            </div>
                            <div id="finance-category-list" class="widget-content">
                            </div>
                        </div>
                    </div>
                    <div id="summary-area" class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing justify-content-center">
                        <div id="finance-summary-widget" class="widget">
                            <div class="widget-heading">
                                Summary
                            </div>
                            <div class="widget-content">
                                <div class="row mb-3">
                                    <div class="col-3 align-self-center">
                                        <span class="icon-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <small class="fw-bold fw-light fst-italic">Incomes</small><br/>
                                        <span class="fw-bold text-success">RM <span id="total-income"></span></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 align-self-center">
                                        <span class="icon-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <small class="fw-light fw-bold fst-italic">Expenses</small><br/>
                                        <span class="fw-bold text-danger">RM <span id="total-expense"></span></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 align-self-center">
                                        <span class="icon-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <small class="fw-light fw-bold fst-italic">Earnings</small><br/>
                                        <span class="fw-bold text-primary">RM <span id="total-earning"></span></span>
                                    </div>
                                </div>
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
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label for="m-title" class="form-label">Title</label>
                                            <input type="text" id="m-title" name="m-title" class="form-control" placeholder="Breakfast.." autocomplete="off" required />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <label for="m-date" class="form-label">Date</label>
                                            <input type="date" id="m-date" name="m-date" class="form-control" placeholder="DD/MM/YYYY" value="<?= date( 'Y-m-d' ) ?>">
                                        </div>
                                        <div class="col-6">
                                            <label for="m-status" class="form-label">Status</label>
                                            <select id="m-status" name="m-status" class="form-select" required >
                                                <option value="" selected >Select Status</option>
                                                <option value="0">Income</option>
                                                <option value="1">Expense</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="m-category" class="form-label">Category</label>
                                            <select id="m-category" name="m-category" class="form-select" required >
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
                                        <div class="col-6">
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
    <script src="<?= '' // $config[ 'urls' ][ 'js' ] . "custom/finance.js"; ?>"></script>
    <script>
        function open_modal() {
            reset_modal();
            $( '#m-finance-record' ).modal( 'show' );
        }

        function close_modal() {
            $( '#m-finance-record' ).modal( 'hide' );
        }

        function close_delete_modal() {
            $( '#m-finance-record-delete' ).modal( 'hide' );
        }

        function reset_modal() {
            $( '#m-title' ).val( '' );
            $( '#m-date' ).val( get_current_day() );
            $( '#m-category' ).prop( 'selectedIndex', 0 );
            $( '#m-status' ).prop( 'selectedIndex', 0 );
            $( '#m-amount' ).val( '' );
        }

        function open_create_finance() {
            $( '#modal-header-title' ).text( 'Add Finance' );
            open_modal();
        }

        function open_update_finance( id ) {
            $('#modal-header-title').text( 'Edit Finance' );
            $( '#m-id' ).val( id );
            open_modal();
            read_finance();
        }

        function open_delete_finance( id ) {
            $( '#m-finance-record-delete' ).modal( 'show' );
            $( '#m-id-delete' ).val( id );
        }

        $( '#finance-record-form' ).submit( ( event ) => {
            event.preventDefault();
            if ( $( '#modal-header-title' ).text() == 'Add Finance' ) {
                create_finance();
            } else {
                update_finance();
            }
        } );

        const table = $( '#table-finance' ).DataTable( {
            headerCallback:function( e, a, t, n, s ) {
                e.getElementsByTagName( "th" )[ 0 ].innerHTML='<label class="new-control new-checkbox checkbox-outline-info m-auto">\n<input type="checkbox" class="new-control-input chk-parent select-customers-info" id="customer-all-info">\n<span class="new-control-indicator"></span><span style="visibility:hidden">c</span>\n</label>'
            },
            columnDefs:[ {
                targets:0, width:"30px", className:"", orderable:!1, render:function(e, a, t, n) {
                    return'<label class="new-control new-checkbox checkbox-outline-info  m-auto">\n<input type="checkbox" class="new-control-input child-chk select-customers-info" id="customer-all-info">\n<span class="new-control-indicator"></span><span style="visibility:hidden">c</span>\n</label>'
                }
            } ],
            dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing Page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search",
                "sLengthMenu": "Results :  _MENU_",
                },
                "lengthMenu": [ 10, 20, 50 ],
                "pageLength": 10 
            } );
        multiCheck( table );

        // CRUD Functions
        function read_finance_summary() {
            $( '#finance-summary-widget' ).block( {
                message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
                fadeIn: 800, 
                fadeOut: 800,
                centerX: 0,
                centerY: 0,
                overlayCSS: {
                    backgroundColor: '#191e3a',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    width: '100%',
                    top: '15px',
                    left: '',
                    right: '10px',
                    bottom: 0,
                    border: 0,
                    color: '#25d5e4',
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            } ); 
            const summary_url = `${ api_url }finance/summary.php`;
            const fk_user_id = $( '#m-user-id' ).val();
            const sent_data = { fk_user_id };
            $.ajax( {
                type    : 'POST',
                url     : summary_url,
                data: sent_data,
                dataType: 'JSON',
                success: ( res ) => {
                    if ( res.result ) {
                        const data = res.data;
                        const { total_income, total_expense, total_earning } = data;
                        $( '#total-income' ).html( total_income );
                        $( '#total-expense' ).html( total_expense );
                        $( '#total-earning' ).html( total_earning );
                        $('#finance-summary-widget').unblock();
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Read Error'
                    } );
                }
            } );
        }

        function read_finance_category_summary() {
            $( '#finance-category-summary-widget' ).block( {
                message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
                fadeIn: 800, 
                fadeOut: 800,
                centerX: 0,
                centerY: 0,
                overlayCSS: {
                    backgroundColor: '#191e3a',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    width: '100%',
                    top: '15px',
                    left: '',
                    right: '10px',
                    bottom: 0,
                    border: 0,
                    color: '#25d5e4',
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            } ); 
            $( '#finance-category-list' ).empty();

            const summary_url = `${ api_url }finance_category/summary.php`;
            const fk_user_id = $( '#m-user-id' ).val();
            const sent_data = { fk_user_id };
            $.ajax( {
                type    : 'POST',
                url     : summary_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        const data = res.data;
                        if ( data.length > 0 ) {
                            let index = 1;
                            const container = $( '#finance-category-list' );
                            let all_element = "";
                            data.forEach( ( row_data ) => {
                                index++;
                                const { category, income, expense } = row_data;
                                const element =   `
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <small class="fw-bold fst-italic">${ category }</small><br/>
                                                </div>
                                                <div class="col-6">
                                                    <span class="fw-bold text-success">RM ${ income }</span>
                                                </div>
                                                <div class="col-6">
                                                    <span class="fw-bold text-danger">RM ${ expense }</span>
                                                </div>
                                            </div>
                                            `;
                                all_element += element;
                            } );
                            container.html( all_element );
                        }
                        $('#finance-category-summary-widget').unblock();
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Read Error'
                    } );
                }
            } );
        }

        function read_all_finance() {
            $( '#table-finance-widget' ).block( {
                message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
                fadeIn: 800, 
                fadeOut: 800,
                centerX: 0,
                centerY: 0,
                overlayCSS: {
                    backgroundColor: '#191e3a',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    width: '100%',
                    top: '15px',
                    left: '',
                    right: '10px',
                    bottom: 0,
                    border: 0,
                    color: '#25d5e4',
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            } ); 
            table.clear().draw();
            const read_all_url = `${ api_url }finance/read_all.php`;
            const fk_user_id = $( '#m-user-id' ).val();
            const sent_data = { fk_user_id };
            $.ajax( {
                type    : 'POST',
                url     : read_all_url,
                data: sent_data,
                dataType: 'JSON',
                success: ( res ) => {
                    if ( res.result ) {
                        const data = res.data;
                        if ( data.length > 0 ) {
                            data.forEach( ( row_data ) => {
                                const { id, title, status, category, amount, date } = row_data;
                                table.row.add( [
                                    `<td class="checkbox-column"> 1 </td>`,
                                    `${ date }`,
                                    `${ title }`,
                                    `${ category }`,
                                    `<span class="${ status == 0 ? 'text-success' : 'text-danger' }">RM ${ amount }</span>`,
                                    `
                                    <button onclick="open_update_finance( ${ id } );" class="btn btn-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </button>
                                    <button onclick="open_delete_finance( ${ id } )" class="btn btn-danger rounded-pill" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                    </button>
                                    `,
                                ] ).draw( false );
                            } );
                        }
                        $('#table-finance-widget').unblock();
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Read All Error'
                    } );
                }
            } );
        }

        function read_finance() {
            const read_url = `${ api_url }finance/read.php`;
            const id = $( '#m-id' ).val();
            const sent_data = { id };
            $.ajax( {
                type    : 'POST',
                url     : read_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        const data = res.data;
                        const { title, date, category_id, status, amount } = data;
                        $( '#m-title' ).val( title );
                        $( '#m-date' ).val( date );
                        $( '#m-category' ).val( category_id );
                        $( '#m-status' ).val( status );
                        $( '#m-amount' ).val( amount );
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Read Error'
                    } );
                }
            } );
        }

        function create_finance() {
            const create_url = `${ api_url }finance/create.php`;
            const title          = $( '#m-title' ).val();
            const date           = $( '#m-date' ).val();
            const fk_category_id = $( '#m-category' ).val();
            const fk_user_id     = $( '#m-user-id' ).val();
            const status         = $( '#m-status' ).val();
            const amount         = $( '#m-amount' ).val();
            const sent_data = { title, date, fk_category_id, fk_user_id, status, amount };
            $.ajax( {
                type    : 'POST',
                url     : create_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        close_modal();
                        refresh();
                        Toast.fire( {
                            icon : 'success',
                            title: 'Create Success'
                        } );
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Create Error'
                    } );
                }
            } );
        }

        function update_finance() {
            const update_url = `${ api_url }finance/update.php`;
            const id             = $( '#m-id' ).val();
            const title          = $( '#m-title' ).val();
            const date           = $( '#m-date' ).val();
            const fk_category_id = $( '#m-category' ).val();
            const status         = $( '#m-status' ).val();
            const amount         = $( '#m-amount' ).val();
            const sent_data = { id, title, date, fk_category_id, status, amount };
            $.ajax( {
                type    : 'POST',
                url     : update_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        close_modal();
                        refresh();
                        Toast.fire( {
                            icon : 'success',
                            title: 'Update Success'
                        } );
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Update Error'
                    } );
                }
            } );
        }

        function delete_finance() {
            const id = $( '#m-id-delete' ).val();
            const delete_url = `${ api_url }finance/delete.php`;
            const sent_data = { id };
            $.ajax( {
                type    : 'POST',
                url     : delete_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        close_delete_modal();
                        refresh();
                        Toast.fire( {
                            icon : 'success',
                            title: 'Delete Success'
                        } );
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Delete Error'
                    } );
                }
            } );
        }

        function refresh() {
            read_all_finance();
            read_finance_summary();
            read_finance_category_summary();
        }

        refresh();
    </script>
    <!-- Finance JS End -->

    <!-- Custom JS End -->
</body>
</html>