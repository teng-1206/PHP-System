<?php include_once( realpath( dirname( __FILE__ ) . "/config/config.php" ) ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Dashboard </title>
    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'css' ] . "finance.css"; ?>" />
    <link rel="stylesheet" href="<?= $config[ 'urls' ][ 'plugins' ] . "pagination/pagination.css"; ?>" />
    <!-- Custom CSS End -->
</head>
<body class="bg-light">
    <!-- Navbar Start -->
    <?php include_once( TEMPLATES_PATH . 'navbar.php' ); ?>
    <!-- Navbar End -->

    <main class="m-5 pt-5">
        <div class="row">
            <div class="col-12 p-3">
                <button id="btn-add" class="btn btn-primary rounded-pill shadow" style="width: 125px; height: 40px;" onclick="open_create_record()">
                    <i class="fas fa-plus-circle"></i> Add
                </button>
            </div>
            <div class="col-6 justify-content-center">
                <div id="list">
                </div>
            </div>
            <div class="col-3 justify-content-center ">
                <div class="card bg-white shadow mb-3 overflow-auto rounded-5" style="" >
                    <div class="card-body p-5 pb-0" >
                        <div class="row">
                            <div class="col-4 align-self-center">
                            <i class="fa-lg fas fa-long-arrow-up text-success"></i>
                            </div>
                            <div class="col-8">
                                <small>Foods & Drink</small><br/>
                                <h5>RM 500.00</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-5 pb-0" >
                        <div class="row">
                            <div class="col-4 align-self-center">
                            <i class="fa-lg fas fa-long-arrow-down text-danger"></i>
                            </div>
                            <div class="col-8">
                                <small>Loan</small><br/>
                                <h5>RM 500.00</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-5" >
                        <div class="row">
                            <div class="col-4 align-self-center">
                            <i class="fa-lg fas fa-dollar-sign text-primary"></i>
                            </div>
                            <div class="col-8">
                                <small>Fuel</small><br/>
                                <h5>RM 500.00</h5>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <small class="fw-light fst-italic">Incomes</small>
                                <h5 class="text-success">RM <span id="total-income"></span></h5>
                                
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
                                <small class="fw-light fst-italic">Expenses</small><br/>
                                <h5 class="text-danger">RM <span id="total-expense"></span></h5>
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
                                <small class="fw-light fst-italic">Earnings</small><br/>
                                <h5 class="text-primary">RM <span id="total-earning"></span></h5>
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
    <script src="<?=  $config[ 'urls' ][ 'plugins' ] . "pagination/pagination.js"; ?>"></script>
    <script>
        let current_page = 1;
        let rows = 6;
        let res_setup_pagination = false;
        const list_element = document.getElementById( 'list' );

        function setup( list_items ) {
            if ( ! res_setup_pagination ) {
                setup_pagination();
            }

            if ( typeof list_items !== 'undefined' && list_element ) {
                display_list( list_items, list_element, rows, current_page );
                display_pagination( list_items, rows );
            }
        }

        function setup_pagination() {
            res_setup_pagination = true;
            const pagination_element = document.createElement( 'div' );
            pagination_element.classList.add( 'card', 'bg-white', 'mb-3', 'shadow', 'overflow-auto', 'rounded-5' );
            pagination_element.innerHTML =  `
                                            <div class="card-body p-3" >
                                                <div id="pagination" class="btn-group"></div>
                                            </div>
                                            `;
            list_element.parentNode.insertBefore( pagination_element, list_element.nextSibling );
        }

        function display_list( items, wrapper, rows_per_page, page ) {
            wrapper.innerHTML = "";
            page--;

            let start = rows_per_page * page;
            let end = start + rows_per_page;
            let paginated_items = items.slice( start, end );

            for ( let i = 0; i < paginated_items.length; i++ )
            {
                let item = paginated_items[ i ];
                wrapper.appendChild( item );
            }
        }

        function display_pagination( items, rows_per_page ) {
            const wrapper = document.getElementById( 'pagination' );
            wrapper.innerHTML = "";

            let page_count = Math.ceil( items.length / rows_per_page );

            for ( let i = 1; i < page_count + 1; i++ )
            {
                if ( i == 1 ) 
                {
                    let prev_btn = prev_pagination_button( items, page_count );
                    wrapper.appendChild( prev_btn );
                }

                let btn = pagination_button( i, page_count, items );
                wrapper.appendChild( btn );

                if ( i == page_count ) 
                {
                    next_btn = next_pagination_button( items, page_count );
                    wrapper.appendChild( next_btn );
                }
            }
        }

        function pagination_button( page, page_count, items ) {
            let button = document.createElement( 'button' );
            button.innerText = page;
            button.classList.add( 'btn', 'btn-outline-primary' );

            if ( current_page == page ) button.classList.add( 'active' );

            button.addEventListener( 'click', function() {
                current_page = page;
                display_list( items, list_element, rows, current_page );

                let current_btn = document.querySelector( '#pagination button.active' );
                current_btn.classList.remove( 'active' );

                let btn_prev = document.getElementById( 'btn-prev' );
                ( current_page == 1 ) ? btn_prev.classList.add( 'disabled' ) : btn_prev.classList.remove( 'disabled' );

                let btn_next = document.getElementById( 'btn-next' );
                ( current_page == page_count ) ? btn_next.classList.add( 'disabled' ) : btn_next.classList.remove( 'disabled' );

                button.classList.add( 'active' );
            } );
            
            return button;
        }

        function next_pagination_button( items, page_count ) {
            let button = document.createElement( 'button' );
            button.innerHTML = "&raquo;";
            button.classList.add( 'btn', 'btn-outline-primary' );
            button.setAttribute( 'id', 'btn-next' );

            if ( current_page == page_count ) button.classList.add( 'disabled' );

            button.addEventListener( 'click', function() {
                current_page = current_page + 1;
                display_list( items, list_element, rows, current_page );

                let current_btn = document.querySelector( '#pagination button.active' );
                current_btn.classList.remove( 'active' );

                let next_current_btn = current_btn.nextElementSibling;
                next_current_btn.classList.add( 'active' );

                let btn_prev = document.getElementById( 'btn-prev' );
                ( current_page == 1 ) ? btn_prev.classList.add( 'disabled' ) : btn_prev.classList.remove( 'disabled' );

                let btn_next = document.getElementById( 'btn-next' );
                ( current_page == page_count ) ? btn_next.classList.add( 'disabled' ) : btn_next.classList.remove( 'disabled' );
            } );

            return button;
        }

        function prev_pagination_button( items, page_count ) {
            let button = document.createElement( 'button' );
            button.innerHTML = "&laquo;";
            button.classList.add( 'btn', 'btn-outline-primary' );
            button.setAttribute( 'id', 'btn-prev' );

            if ( current_page == 1 ) button.classList.add( 'disabled' );

            button.addEventListener( 'click', function() {
                current_page = current_page - 1;
                display_list( items, list_element, rows, current_page );

                let current_btn = document.querySelector( '#pagination button.active' );
                current_btn.classList.remove( 'active' );

                let prev_current_btn = current_btn.previousElementSibling;
                prev_current_btn.classList.add( 'active' );

                let btn_prev = document.getElementById( 'btn-prev' );
                ( current_page == 1 ) ? btn_prev.classList.add( 'disabled' ) : btn_prev.classList.remove( 'disabled' );

                let btn_next = document.getElementById( 'btn-next' );
                ( current_page == page_count ) ? btn_next.classList.add( 'disabled' ) : btn_next.classList.remove( 'disabled' );
            } );

            return button;
        }

    </script>

    <script>
        function open_modal() {
            reset_modal();
            $( '#m-finance-record' ).modal( 'show' );
        }

        function close_modal() {
            $( '#m-finance-record' ).modal( 'hide' );
        }

        function reset_modal() {
            $( '#m-title' ).val( '' );
            $( '#m-date' ).val( '<?= date( 'Y-m-d' ) ?>' );
            $( '#m-category' ).prop( 'selectedIndex', 0 );
            $( '#m-status' ).prop( 'selectedIndex', 0 );
            $( '#m-amount' ).val( '' );
        }

        function open_create_record() {
            $( '#modal-header-title' ).text( 'Add Record' );
            open_modal();
        }

        function open_update_record( id ) {
            $('#modal-header-title').text( 'Edit Record' );
            $( '#m-id' ).val( id );
            open_modal();
            read_record();
        }

        $( '#finance-record-form' ).submit( ( event ) => {
            event.preventDefault();
            if ( $( '#modal-header-title' ).text() == 'Add Record' ) {
                create_record();
            } else {
                update_record();
            }
            
        } );

        // CRUD Functions
        function read_summary() {
            const summary_url = `${ api_url }finance/summary.php`;
            const sent_data = {};
            $.ajax( {
                type    : 'GET',
                url     : summary_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        const data = res.data;
                        const { total_income, total_expense, total_earning } = data;
                        $( '#total-income' ).html( total_income );
                        $( '#total-expense' ).html( total_expense );
                        $( '#total-earning' ).html( total_earning );
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

        function read_all_record() {
            const read_all_url = `${ api_url }finance/read_all.php`;
            const sent_data = {};
            $.ajax( {
                type    : 'GET',
                url     : read_all_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        const data = res.data;
                        let list_items = [];
                        if ( data.length > 0 ) {
                            data.forEach( ( row_data ) => {
                                const item_element = document.createElement( 'div' );
                                item_element.classList.add( 'card', 'bg-white', 'mb-3', 'shadow', 'rounded-5' );
                                const item = `
                                                <div class="card-body" >
                                                    <div class="row">
                                                        <div class="col-1 text-center align-self-center">
                                                            <i class="${ row_data[ 'icon_code' ] } p-3 rounded-circle" style="color: #${ row_data[ 'color_code' ] }; background-color: #${ row_data[ 'background_color_code' ] }"></i>
                                                        </div>
                                                        <div class="col-6">
                                                            <h5>${ row_data[ 'title' ] }</h5>
                                                            <small class="fw-light fst-italic">${ row_data[ 'create_at' ] }</small>
                                                        </div>
                                                        <div class="col-2 text-end align-self-center ${ row_data[ 'status' ] == 0 ? 'text-success' : 'text-danger' } fw-bold">
                                                            ${ row_data[ 'status' ] == 0 ? '&#43;' : '&#45;' }  RM ${ row_data[ 'amount' ] }
                                                        </div>
                                                        <div class="col-3 text-end align-self-center">
                                                            <span class="button-hover rounded-circle" onclick="open_update_record( ${ row_data[ 'id' ] } )">
                                                                <i class="fas fa-pen fa-lg"></i>
                                                            </span>
                                                            <span class="button-hover rounded-circle" onclick="delete_record( ${ row_data[ 'id' ] } )">
                                                                <i class="fas fa-times-circle fa-lg"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                item_element.innerHTML = item;
                                list_items.push( item_element );
                            } );
                        }
                        setup( list_items );
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

        function read_record() {
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

        function create_record() {
            const create_url = `${ api_url }finance/create.php`;
            const title          = $( '#m-title' ).val();
            const date           = $( '#m-date' ).val();
            const fk_category_id = $( '#m-category' ).val();
            const status         = $( '#m-status' ).val();
            const amount         = $( '#m-amount' ).val();
            const sent_data = { title, date, fk_category_id, status, amount };
            $.ajax( {
                type    : 'POST',
                url     : create_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        close_modal();
                        read_all_record();
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

        function update_record() {
            const update_url = `${ api_url }finance/update.php`;
            const id          = $( '#m-id' ).val();
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
                        read_all_record();
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

        function delete_record( id ) {
            Swal.fire( {
                title             : 'Delete this record?',
                icon              : 'question',
                showCancelButton  : true,
                confirmButtonText : 'Delete',
                denyButtonText    : 'Cancel',
                confirmButtonColor: '#dc3545',
                reverseButtons    : true,
            } ).then( ( result ) => {
                if ( result.isConfirmed ) {
                    const delete_url = `${ api_url }finance/delete.php`;
                    const sent_data = { id };
                    $.ajax( {
                        type    : 'POST',
                        url     : delete_url,
                        dataType: 'JSON',
                        data    : sent_data,
                        success: ( res ) => {
                            if ( res.result ) {
                                read_all_record();
                                read_summary();
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
            } );
        }

        read_all_record();
        read_summary();
    </script>

    <!-- Custom JS End -->
</body>
</html>