<?php include_once( realpath( dirname( __FILE__ ) . "//assets//config//config.php" ) ); ?>
<?php include_once( TEMPLATES_PATH . 'validation.php' ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Finance Category </title>

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
                                <li class="breadcrumb-item active" aria-current="page"><span>Finance Category</span></li>
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
                    <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget">
                            <div class="widget-heading">
                                <h5 class="mb-4">Finance Category</h5>
                            </div>
                            <div class="widget-content">
                                <table id="table-finance-category" class="table style-1 dt-table-hover non-hover">
                                    <thead>
                                        <tr>
                                            <th class="checkbox-column dt-no-sorting"> Record no. </th>
                                            <!-- <th>Icon</th> -->
                                            <th>Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing justify-content-center">
                        <div class="widget">
                            <div class="widget-heading">
                            <h5 id="modal-header-title" class="mb-4">Add Category</h5>
                            </div>
                            <div class="widget-content">
                            <form id="finance-category-form">
                                    <input type="hidden" id="m-id" name="m-id" value="">
                                    <input type="hidden" id="m-user-id" name="m-user-id" value="1">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label for="m-category" class="form-label">Category</label>
                                            <input type="text" id="m-category" name="m-category" class="form-control" placeholder="Breakfast.." autocomplete="off" required />
                                        </div>
                                    </div>
                                    <!-- <div class="row mb-4"> -->
                                        <!-- <div class="col-12 form-group"> -->
                                            <!-- <label for="m-icon" class="form-label">Icon</label> -->
                                            <!-- <input type="text" id="m-icon" name="m-icon" class="form-control" placeholder="fas fa-archive" autocomplete="off" required /> -->
                                            <input type="hidden" id="m-icon" name="m-icon" class="form-control" placeholder="fas fa-archive" autocomplete="off" required value="a" />
                                        <!-- </div> -->
                                    <!-- </div> -->
                                    <!-- <div class="row mb-4"> -->
                                        <!-- <div class="col-6"> -->
                                            <!-- <label for="m-color" class="form-label">Color</label> -->
                                            <!-- <input type="color" id="m-color" name="m-color" class="form-control form-control-color" autocomplete="off" required /> -->
                                            <input type="hidden" id="m-color" name="m-color" class="form-control form-control-color" autocomplete="off" required value="#fff" />
                                        <!-- </div> -->
                                        <!-- <div class="col-6"> -->
                                            <!-- <label for="m-background-color" class="form-label">Background Color</label> -->
                                            <!-- <input type="color" id="m-background-color" name="m-background-color" class="form-control form-control-color" autocomplete="off" required /> -->
                                            <input type="hidden" id="m-color" name="m-color" class="form-control form-control-color" autocomplete="off" required value="#fff" />
                                        <!-- </div> -->
                                    <!-- </div> -->
                                    <div class="row">
                                        <div class="col-12 text-end">
                                            <button id="m-btn-reset" name="m-btn-reset" type="reset" class="btn rounded-pill" form="finance-category-form" style="width: 100px; height: 40px;" onclick="reset_modal()">Reset</button>
                                            <button id="m-btn-submit" name="m-btn-submit" type="submit" class="btn btn-primary rounded-pill" form="finance-category-form" style="width: 100px; height: 40px;" onclick="">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Finance Category Delete Modal Start -->
            <div class="modal fade back-blur-3" id="m-finance-category-delete" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn btn-danger rounded-pill" style="width: 100px; height: 40px;" onclick="delete_finance_category()">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Finance Category Delete Modal End -->

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

    <!-- Finance Category JS Start -->
    <script src="<?= $config[ 'urls' ][ 'js' ] . "custom/finance_category.js"; ?>"></script>
    <!-- Finance Category JS End -->

    <!-- Custom JS End -->
</body>
</html>