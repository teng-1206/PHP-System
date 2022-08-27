<?php include_once( realpath( dirname( __FILE__ ) . "/config/config.php" ) ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Finance Category </title>
    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->
    <!-- Data Table Start -->
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'plugins' ] . "data-table/data-table.min.css"; ?>" />
    <!-- Data Table End -->
    <!-- <link rel="stylesheet" href="dist/css/bootstrap-iconpicker.min.css"/> -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/> -->
    <link rel="stylesheet" href="<?=''// $config[ 'urls' ][ 'plugins' ] . "font-awesome-icon-picker/font-awesome-icon-picker.min.css"; ?>" />
    <link rel="stylesheet" href="<?= ''//$config[ 'urls' ][ 'plugins' ] . "font-awesome-icon-picker/font-awesome-icon-picker.css"; ?>" />
    <!-- Custom CSS End -->
</head>
<body>
    <!-- Navbar Start -->
    <?php include_once( TEMPLATES_PATH . 'navbar.php' ); ?>
    <!-- Navbar End -->

    <main class="m-5 pt-5">
        <div class="row">
        <div class="col-9 justify-content-center">
                <div class="card bg-white shadow mb-3 rounded-5" >
                    <div class="card-body p-4">
                        <h5 class="mb-4">Finance Category</h5>
                        <table id="table-finance-category" class="table align-self-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Icon</th>
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
            <div class="col-3 justify-content-center">
                <div class="card bg-white shadow mb-3 rounded-5" style="" >
                    <div class="card-body p-4">
                        <h5 id="modal-header-title" class="mb-4">Add Category</h5>
                        <form id="finance-category-form">
                            <input type="hidden" id="m-id" name="m-id" value="">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="m-category" class="form-label">Category</label>
                                    <input type="text" id="m-category" name="m-category" class="form-control" placeholder="Breakfast.." autocomplete="off" required />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 form-group">
                                    <label for="m-icon" class="form-label">Icon</label>
                                    <input type="text" id="m-icon" name="m-icon" class="form-control" placeholder="fas fa-archive" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label for="m-color" class="form-label">Color</label>
                                    <input type="color" id="m-color" name="m-color" class="form-control form-control-color" autocomplete="off" required />
                                </div>
                                <div class="col-6">
                                    <label for="m-background-color" class="form-label">Background Color</label>
                                    <input type="color" id="m-background-color" name="m-background-color" class="form-control form-control-color" autocomplete="off" required />
                                </div>
                            </div>
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
    </main>

    <!-- Global JS Start -->
    <?php include_once( TEMPLATES_PATH . 'foot.php' ); ?>
    <!-- Global JS End -->

    <!-- Custom JS Start -->
    <!-- Data Table Start -->
    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "data-table/data-table.min.js"; ?>"></script>
    <!-- Data Table End -->

    <!-- Custom JS Start -->
    <script src="<?= $config[ 'urls' ][ 'js' ] . "finance_category.js"; ?>"></script>
    <!-- Custom JS End -->

    <!-- Bootstrap CDN -->
    <!-- <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script> -->
    <!-- Bootstrap-Iconpicker Bundle -->
    <!-- <script type="text/javascript" src="dist/js/bootstrap-iconpicker.bundle.min.js"></script> -->
    <script src="<?=''// $config[ 'urls' ][ 'plugins' ] . "font-awesome-icon-picker/font-awesome-icon-picker.min.js"; ?>"></script>
    <script src="<?= '' //$config[ 'urls' ][ 'plugins' ] . "font-awesome-icon-picker/font-awesome-icon-picker.js"; ?>"></script>

    <script>
        $( '#table-finance-category' ).DataTable();
    </script>
    <!-- Custom JS End -->
</body>
</html>