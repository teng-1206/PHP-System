<?php include_once( realpath( dirname( __FILE__ ) . "/config/config.php" ) ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Dashboard </title>
    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'plugins' ] . "pagination/pagination.css"; ?>" />
    <!-- Custom CSS End -->
</head>
<body class="bg-light">
    <!-- Navbar Start -->
    <?php include_once( TEMPLATES_PATH . 'navbar.php' ); ?>
    <!-- Navbar End -->

    <main class="m-5 pt-5">
        <div class="row">
            <div class="col-6 justify-content-center">
                <div class="card bg-white shadow mb-3 overflow-auto rounded-5" style="" >
                    <div class="card-body p-4" >
                        <button id="btn-add-record" class="btn btn-primary rounded-pill shadow mb-3" style="width: 125px; height: 40px;" onclick="open_create_finance()">
                            <i class="fas fa-plus-circle"></i> Add
                        </button>
                        <div id="list" class="mb-5">
                        </div>
                        <div id="pagination">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 justify-content-center ">
                <div id="finance-category-list" class="card bg-white shadow mb-3 overflow-auto rounded-5" ></div>
            </div>
            <div class="col-3 justify-content-center ">
                <div class="card bg-white shadow mb-3 rounded-5" style="" >
                    <div class="card-body p-5 pb-0" >
                        <div class="row">
                            <div class="col-4 align-self-center">
                                <span class="icon-success">
                                    <i class="fa-lg fas fa-long-arrow-up"></i>
                                </span>
                            </div>
                            <div class="col-8">
                                <small class="fw-bold fw-light fst-italic">Incomes</small><br/>
                                <span class="fw-bold text-success">RM <span id="total-income"></span></span>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-5 pb-0" >
                        <div class="row">
                            <div class="col-4 align-self-center">
                                <span class="icon-danger">
                                    <i class="fa-lg fas fa-long-arrow-down"></i>
                                </span>
                            </div>
                            <div class="col-8">
                                <small class="fw-light fw-bold fst-italic">Expenses</small><br/>
                                <span class="fw-bold text-danger">RM <span id="total-expense"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-5" >
                        <div class="row">
                            <div class="col-4 align-self-center">
                                <span class="icon-primary">
                                    <i class="fa-lg fas fa-dollar-sign"></i>
                                </span>
                            </div>
                            <div class="col-8">
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="finance-record-form">
                            <input type="hidden" id="m-id" name="m-id" value="">
                            <input type="hidden" id="m-user-id" name="m-user-id" value="1">
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
                                            include_once( MODULES_PATH . "/finance_category.php" );
                                            $finance_category_data_connector = new Finance_Category_Data_Connector();
                                            $all_finance_category = $finance_category_data_connector->read_all( $conn );
                                            if ( ! is_null( $all_finance_category ) ) :
                                                foreach ( $all_finance_category as $finance_category ) :
                                                ?>
                                                    <option value="<?= $finance_category[ 'id' ] ?>">
                                                        <?= $finance_category[ 'category' ] ?>
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
                        <button id="m-btn-cancel" name="m-btn-cancel" type="button" class="btn rounded-pill" data-bs-dismiss="modal" style="width: 100px; height: 40px;">Cancel</button>
                        <button id="m-btn-submit" name="m-btn-submit" type="submit" class="btn btn-primary rounded-pill" form="finance-record-form" style="width: 100px; height: 40px;" onclick="">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Finance Record Modal End -->
    </main>

    <!-- Global JS Start -->
    <?php include_once( TEMPLATES_PATH . 'foot.php' ); ?>
    <!-- Global JS End -->

    <!-- Custom JS Start -->
    <!-- Pagination Start -->
    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "pagination/pagination.js"; ?>"></script>
    <!-- Pagination End -->

    <!-- Finance JS Start -->
    <script src="<?= $config[ 'urls' ][ 'js' ] . "finance.js"; ?>"></script>
    <!-- Finance JS End -->
    <!-- Custom JS End -->
</body>
</html>