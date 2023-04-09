
const finance_record                 = $( '#m-finance-record' );
const finance_record_delete          = $( '#m-finance-delete-record' );
const finance_category_record        = $( '#m-finance-category-record' );
const finance_category_record_delete = $( '#m-finance-category-delete-record' );
const wallet_record                  = $( '#m-wallet-record' );
const wallet_record_delete           = $( '#m-wallet-delete-record' );
const manage_wallet                  = $( '#m-manage-wallet' );
const manage_finance_category = $( '#m-manage-finance-category' );

// ! Finance 
/**
 * Resets the form inside the finance modal, clearing all values.
 */
function reset_finance_modal() {
    finance_record.find( '#title' ).val( '' );
    finance_record.find( '#date' ).val( get_current_day() );
    finance_record.find( '#category' ).prop( 'selectedIndex', 0 );
    finance_record.find( '#status' ).prop( 'selectedIndex', 0 );
    finance_record.find( '#amount' ).val( '' );
}

/**
 * Opens the finance modal and resets its form.
 */
function open_finance_modal() {
    reset_finance_modal();
    finance_record.modal( 'show' );
}

/**
 * Closes the finance modal.
 */
function close_finance_modal() {
    finance_record.modal( 'hide' );
}

/**
 * Closes the delete finance modal.
 */
function close_finance_delete_modal() {
    finance_record_delete.modal( 'hide' );
}

/**
 * Opens the finance modal with a header title for adding a new finance record.
 */
function open_create_finance() {
    finance_record.find( '#modal-header-title' ).text( 'Add Finance' );
    open_finance_modal();
}

/**
 * Opens the finance modal with a header title for editing an existing finance record.
 * @param {string} id - The ID of the finance record to edit.
 */
function open_update_finance( id ) {
    finance_record.find( '#modal-header-title' ).text( 'Edit Finance' );
    finance_record.find( '#id' ).val( id );
    open_finance_modal();
    read_finance();
}

/**
 * Opens the delete finance modal for the specified finance record ID.
 * @param {string} id - The ID of the finance record to delete.
 */
function open_delete_finance( id ) {
    finance_record_delete.modal( 'show' );
    finance_record_delete.find( '#id' ).val( id );
}


$( '#finance-record-form' ).submit( ( event ) => {
    event.preventDefault();
    if ( finance_record.find( '#modal-header-title' ).text() == 'Add Finance' ) {
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
        "lengthMenu": [ 8, 20, 50 ],
        "pageLength": 8 
} );
multiCheck( table );


function read_finance_summary() {
    $( '.finance-summary-widget' ).block( {
        message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
        fadeIn: 800, 
        fadeOut: 800,
        centerX: 0,
        centerY: 0,
        overlayCSS: {
            backgroundColor: '#191e3a',
            opacity: 0.8,
            cursor: 'wait',
            borderRadius: '1rem',
        },
        css: {
            width: '100%',
            top: '50%',
            left: '',
            right: '0px',
            bottom: 0,
            border: 0,
            color: '#25d5e4',
            padding: 0,
            backgroundColor: 'transparent'
        }
    } ); 
    const summary_url = `${ api_url }finance/summary.php`;
    const fk_wallet_id = $( '#wallet-id' ).val();
    const fk_user_id   = finance_record.find( '#user-id' ).val();
    const select_date  = $( '#select-date' ).val();
    const sent_data    = { fk_wallet_id, fk_user_id, select_date };
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
                $('.finance-summary-widget').unblock();
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
    $( '#finance-category-list' ).empty();
    $( '#finance-category-summary-widget' ).block( {
        message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
        fadeIn: 800, 
        fadeOut: 800,
        centerX: 0,
        centerY: 0,
        overlayCSS: {
            backgroundColor: '#191e3a',
            opacity: 0.8,
            cursor: 'wait',
            borderRadius: '1rem',
        },
        css: {
            width: '100%',
            top: '50%',
            left: '',
            right: '0px',
            bottom: 0,
            border: 0,
            color: '#25d5e4',
            padding: 0,
            backgroundColor: 'transparent'
        }
    } );
    const summary_url = `${ api_url }finance_category/summary.php`;
    const fk_wallet_id = $( '#wallet-id' ).val();
    const fk_user_id   = finance_record.find( '#user-id' ).val();
    const select_date  = $( '#select-date' ).val();
    const sent_data    = { fk_wallet_id, fk_user_id, select_date };
    $.ajax( {
        type    : 'POST',
        url     : summary_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            if ( res.result ) {
                const data = res.data;
                const container = $( '#finance-category-list' );

                if ( data.length > 0 ) {
                    let index = 1;
                    let all_element = "";
                    data.forEach( ( row_data ) => {
                        index++;
                        const { category, income, expense } = row_data;
                        const income_color = income == '0.00' ? 'text-dark' : 'text-success';
                        const expense_color = expense == '0.00' ? 'text-dark' : 'text-danger';
                        const element =   `
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <small class="fw-bold fst-italic">${ category }</small><br/>
                                        </div>
                                        <div class="col-6">
                                            <span class="fw-bold ${ income_color }">RM ${ income }</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="fw-bold ${ expense_color }">RM ${ expense }</span>
                                        </div>
                                    </div>
                                    `;
                        all_element += element;
                    } );
                    container.html( all_element );
                } else {
                    const element = `<small>No Data Available </small>`;
                    container.html( element );
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
    $( '#table-area' ).block( {
        message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
        fadeIn: 800, 
        fadeOut: 800,
        centerX: 0,
        centerY: 0,
        overlayCSS: {
            backgroundColor: '#191e3a',
            opacity: 0.8,
            cursor: 'wait',
            borderRadius: '1rem',
            width: '98%',
            height: '97%',
            top: '0px',
            left: '1%',
            right: '0px',
        },
        css: {
            width: '100%',
            top: '50%',
            left: '',
            right: '0px',
            bottom: 0,
            border: 0,
            color: '#25d5e4',
            padding: 0,
            backgroundColor: 'transparent'
        }
    } ); 
    table.clear().draw();
    const read_all_url = `${ api_url }finance/read_all.php`;
    const fk_user_id   = finance_record.find( '#user-id' ).val();
    const fk_wallet_id = $( '#wallet-id' ).val();
    const select_date = $( '#select-date' ).val();
    const sent_data = { fk_wallet_id, fk_user_id, select_date };
    $.ajax( {
        type    : 'POST',
        url     : read_all_url,
        data: sent_data,
        dataType: 'JSON',
        success: ( res ) => {
            if ( res.result ) {
                console.log(res);
                const data = res.data;
                if ( data.length > 0 ) {
                    data.forEach( ( row_data ) => {
                        const { id, title, status, category, amount, date } = row_data;
                        table.row.add( [
                            `<td class="checkbox-column"> 1 </td>`,
                            `${ date.split(" ")[0] }`,
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
                table.order( 1 ).draw()
                $( '#table-area' ).unblock();
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
    const id = finance_record.find( '#id' ).val();
    const sent_data = { id };
    $.ajax( {
        type    : 'POST',
        url     : read_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log(res);
            if ( res.result ) {
                const data = res.data;
                const { title, date, category_id, status, amount } = data;
                finance_record.find( '#title' ).val( title );
                finance_record.find( '#date' ).val( get_date( date ) );
                finance_record.find( '#category' ).val( category_id );
                finance_record.find( '#status' ).val( status );
                finance_record.find( '#amount' ).val( amount );
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
    const title          = finance_record.find( '#title' ).val();
    const date           = finance_record.find( '#date' ).val();
    const fk_category_id = finance_record.find( '#category' ).val();
    const fk_wallet_id     = $( '#wallet-id' ).val();
    const fk_user_id   = finance_record.find( '#user-id' ).val();
    const status       = finance_record.find( '#status' ).val();
    const amount       = finance_record.find( '#amount' ).val();
    const sent_data = { title, date, fk_category_id, fk_wallet_id, fk_user_id, status, amount };
    $.ajax( {
        type    : 'POST',
        url     : create_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log(res);
            if ( res.result ) {
                close_finance_modal();
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
    const id             = finance_record.find( '#id' ).val();
    const title          = finance_record.find( '#title' ).val();
    const date           = finance_record.find( '#date' ).val();
    const fk_category_id = finance_record.find( '#category' ).val();
    const fk_wallet_id = $( '#wallet-id' ).val();
    const status         = finance_record.find( '#status' ).val();
    const amount         = finance_record.find( '#amount' ).val();
    const sent_data = { id, title, date, fk_category_id, fk_wallet_id, status, amount };
    $.ajax( {
        type    : 'POST',
        url     : update_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log(res);
            if ( res.result ) {
                close_finance_modal();
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
    const id = finance_record_delete.find( '#id' ).val();
    const delete_url = `${ api_url }finance/delete.php`;
    const sent_data = { id };
    $.ajax( {
        type    : 'POST',
        url     : delete_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log(res);
            if ( res.result ) {
                close_finance_delete_modal();
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


//  ! Finance Category
/**
 * Opens the finance_category modal and resets its form.
 */
function open_manage_finance_category_modal() {
    read_all_finance_category();
    manage_finance_category.modal( 'show' );
}

/**
 * Closes the finance_category modal.
 */
function close_manage_finance_category_modal() {
    manage_finance_category.modal( 'hide' );
}

/**
 * Resets the form inside the finance category modal, clearing all values.
 */
function reset_finance_category_modal() {
    finance_category_record.find( '#category' ).val( '' );
    // finance_category_record.find( '#icon' ).val( '' );
    // finance_category_record.find( '#color' ).prop( '' );
    // finance_category_record.find( '#background-color' ).prop( '' );
}

/**
 * Opens the finance_category modal and resets its form.
 */
function open_finance_category_modal() {
    reset_finance_category_modal();
    finance_category_record.modal( 'show' );
}

/**
 * Closes the finance_category modal.
 */
function close_finance_category_modal() {
    finance_category_record.modal( 'hide' );
}

function cancel_finance_category_modal() {
    if ( finance_category_record.find( '#modal-header-title' ).text() == 'Edit Category' ) {
        open_manage_finance_category_modal();
    }
    close_finance_category_modal();
}

/**
 * Closes the delete finance_category modal.
 */
function close_finance_category_delete_modal() {
    finance_category_record_delete.modal( 'hide' );
}

function cancel_finance_category_delete_modal() {
    close_finance_category_delete_modal();
    open_manage_finance_category_modal();
}

/**
 * Opens the finance_category modal with a header title for adding a new finance_category record.
 */
function open_create_finance_category() {
    finance_category_record.find( '#modal-header-title' ).text( 'Add Category' );
    open_finance_category_modal();
}

/**
 * Opens the finance category modal with a header title for editing an existing finance category record.
 * @param {string} id - The ID of the finance category record to edit.
 */
function open_update_finance_category( id ) {
    close_manage_finance_category_modal();
    finance_category_record.find( '#modal-header-title' ).text( 'Edit Category' );
    finance_category_record.find( '#id' ).val( id );
    open_finance_category_modal();
    read_finance_category();
}

/**
 * Opens the delete finance_category modal for the specified finance_category record ID.
 * @param {string} id - The ID of the finance_category record to delete.
 */
function open_delete_finance_category( id ) {
    close_manage_finance_category_modal();
    finance_category_record_delete.modal( 'show' );
    finance_category_record_delete.find( '#id' ).val( id );
}


function read_all_finance_category() {
    // $( '#table-area' ).block( {
    //     message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
    //     fadeIn: 800, 
    //     fadeOut: 800,
    //     centerX: 0,
    //     centerY: 0,
    //     overlayCSS: {
    //         backgroundColor: '#191e3a',
    //         opacity: 0.8,
    //         cursor: 'wait',
    //         borderRadius: '1rem',
    //     },
    //     css: {
    //         width: '100%',
    //         top: '50%',
    //         left: '',
    //         right: '0px',
    //         bottom: 0,
    //         border: 0,
    //         color: '#25d5e4',
    //         padding: 0,
    //         backgroundColor: 'transparent'
    //     }
    // } ); 
    // table.clear().draw();
    const container = $( '#finance-category-content-area' );
    container.empty();
    const read_all_url = `${ api_url }finance_category/read_all.php`;
    const fk_user_id = finance_category_record.find( '#user-id' ).val();
    const sent_data = { fk_user_id };
    $.ajax( {
        type    : 'POST',
        url     : read_all_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log( res );
            if ( res.result ) {
                const data = res.data;
                if ( data.length > 0 ) {
                    let all_element = '';
                    data.forEach( ( row_data ) => {
                        const { id, category, color_code, background_color_code, icon_code } = row_data;
                        const element = `
                                        <div class="card component-card_4">
                                            <div class="card-body">
                                                <div class="user-profile col-4">
                                                    <img src="assets/img/90x90.jpg" class="" alt="..." width="70" height="70">
                                                </div>
                                                <div class="user-info col">
                                                    <h5 class="card-user_name">${ category }</h5>
                                                </div>
                                                <div class="float-right pt-3 pr-3" style="place-self: self-start;" >
                                                    <div class="dropdown d-inline-block">
                                                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                        </a>
                                                        <div class="dropdown-menu left" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(-141px, 19px, 0px); top: 0px; left: 0px;" x-placement="bottom-end">
                                                            <a class="dropdown-item" href="javascript:void( open_update_finance_category( ${ id } ) );">Update</a>
                                                            <a class="dropdown-item" href="javascript:void( open_delete_finance_category( ${ id } ) );">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        `; 
                        all_element += element;
                    } );

                    container.html( all_element );
                }
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

function read_finance_category() {
    const read_url = `${ api_url }finance_category/read.php`;
    const id = finance_category_record.find( '#id' ).val();
    const sent_data = { id };
    $.ajax( {
        type    : 'POST',
        url     : read_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            if ( res.result ) {
                const data = res.data;
                const { category, color_code, background_color_code, icon_code } = data;
                finance_category_record.find( '#category' ).val( category );
                finance_category_record.find( '#icon' ).val( icon_code );
                finance_category_record.find( '#color' ).val( color_code );
                finance_category_record.find( '#background-color' ).val( background_color_code );
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

function create_finance_category() {
    const create_url = `${ api_url }finance_category/create.php`;
    const fk_user_id            = finance_category_record.find( '#user-id' ).val();
    const category              = finance_category_record.find( '#category' ).val();
    const icon_code             = finance_category_record.find( '#icon' ).val();
    const color_code            = finance_category_record.find( '#color' ).val();
    const background_color_code = finance_category_record.find( '#background-color' ).val();
    const sent_data = { fk_user_id, category, icon_code, color_code, background_color_code };
    $.ajax( {
        type    : 'POST',
        url     : create_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            if ( res.result ) {
                close_finance_category_modal();
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

function update_finance_category() {
    const update_url = `${ api_url }finance_category/update.php`;
    const id                    = finance_category_record.find( '#id' ).val();
    const category              = finance_category_record.find( '#category' ).val();
    const icon_code             = finance_category_record.find( '#icon' ).val();
    const color_code            = finance_category_record.find( '#color' ).val();
    const background_color_code = finance_category_record.find( '#background-color' ).val();
    const sent_data = { id, category, icon_code, color_code, background_color_code };
    $.ajax( {
        type    : 'POST',
        url     : update_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            if ( res.result ) {
                open_manage_finance_category_modal();
                close_finance_category_modal();
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

function delete_finance_category() {
    const id = finance_category_record_delete.find( '#id' ).val();
    const delete_url = `${ api_url }finance_category/delete.php`;
    const sent_data = { id };
    $.ajax( {
        type    : 'POST',
        url     : delete_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            if ( res.result ) {
                open_manage_finance_category_modal();
                close_finance_category_delete_modal();
                refresh();
                Toast.fire( {
                    icon : 'success',
                    title: 'Delete Finance Category Success'
                } );
            }
            return res;
        },
        error: ( err ) => {
            Toast.fire( {
                icon : 'error',
                title: 'Delete Finance Category Error'
            } );
        }
    } );
}

$( '#finance-category-record-form' ).submit( ( event ) => {
    event.preventDefault();
    if ( finance_category_record.find( '#modal-header-title' ).text() == 'Add Category' ) {
        create_finance_category();
    } else {
        update_finance_category();
    }
} );



// ! Wallet

function select_wallet( id ) {
    $( '#wallet-id' ).val( id );
    read_wallet_summary();
    close_manage_wallet_modal();
    refresh();
}

function open_manage_wallet_modal() {
    read_all_wallet();
    manage_wallet.modal( 'show' );
}

function close_manage_wallet_modal() {
    manage_wallet.modal( 'hide' );
}

/**
 * Resets the form inside the wallet modal, clearing all values.
 */
function reset_wallet_modal() {
    wallet_record.find( '#name' ).val( '' );
    wallet_record.find( '#category' ).prop( 'selectedIndex', 0 );
    wallet_record.find( '#amount' ).val( '0.00' );
}

/**
 * Opens the wallet modal and resets its form.
 */
function open_wallet_modal() {
    reset_wallet_modal();
    wallet_record.modal( 'show' );
}

/**
 * Closes the wallet modal.
 */
function close_wallet_modal() {
    wallet_record.modal( 'hide' );
}

function cancel_wallet_modal() {
    if ( wallet_record.find( '#modal-header-title' ).text() == 'Edit Wallet' ) {
        open_manage_wallet_modal();
    } 
    close_wallet_modal();
}

/**
 * Closes the delete wallet modal.
 */
function close_wallet_delete_modal() {
    wallet_record_delete.modal( 'hide' );
}

function cancel_wallet_delete_modal() {
    close_wallet_delete_modal();
    open_manage_wallet_modal();
}

/**
 * Opens the wallet modal with a header title for adding a new wallet record.
 */
function open_create_wallet() {
    wallet_record.find( '#modal-header-title' ).text( 'Add Wallet' );
    open_wallet_modal();
}

/**
 * Opens the wallet modal with a header title for editing an existing wallet record.
 * @param {string} id - The ID of the wallet record to edit.
 */
function open_update_wallet( id ) {
    close_manage_wallet_modal();
    wallet_record.find( '#modal-header-title' ).text( 'Edit Wallet' );
    wallet_record.find( '#id' ).val( id );
    open_wallet_modal();
    read_wallet();
}

/**
 * Opens the delete wallet modal for the specified wallet record ID.
 * @param {string} id - The ID of the wallet record to delete.
 */
function open_delete_wallet( id ) {
    close_manage_wallet_modal();
    wallet_record_delete.modal( 'show' );
    wallet_record_delete.find( '#id' ).val( id );
}

function read_wallet_summary() {
    const read_url = `${ api_url }wallet/read.php`;
    const id = $( '#wallet-id' ).val();
    const sent_data = { id };
    $.ajax( {
        type    : 'POST',
        url     : read_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log(res);
            if ( res.result ) {
                const data = res.data;
                const { name, category, amount } = data;
                $( '#current-wallet-name' ).text( name );
                $( '#current-wallet-amount' ).text( amount );
            }
            return res;
        },
        error: ( err ) => {
            Toast.fire( {
                icon : 'error',
                title: 'Read Wallet Error'
            } );
        }
    } );
}

function read_all_wallet() {
    const container = $( '#wallet-content-area' );
    container.empty();
    const read_url = `${ api_url }wallet/read_all.php`;
    const fk_user_id = wallet_record.find( '#user-id' ).val();
    const sent_data = { fk_user_id };
    $.ajax( {
        type    : 'POST',
        url     : read_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log( res );
            const data = res.data;
            if ( data.length > 0 ) {
                let all_element = '';
                data.forEach( ( row_data ) => {
                    const { id, name, category } = row_data;
                    const element = `
                                    <div class="card component-card_4">
                                        <div class="card-body">
                                            <div class="user-profile col-4">
                                                <img src="assets/img/90x90.jpg" class="" alt="..." width="70" height="70">
                                            </div>
                                            <div class="user-info col">
                                                <h5 class="card-user_name">${ name }</h5>
                                                <span class="card-user_occupation">${ category }</span>
                                            </div>
                                            <div class="float-right pt-3 pr-3" style="place-self: self-start;" >
                                                    <div class="dropdown d-inline-block">
                                                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                        </a>
                                                        <div class="dropdown-menu left" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(-141px, 19px, 0px); top: 0px; left: 0px;" x-placement="bottom-end">
                                                            <a class="dropdown-item" href="javascript:void( select_wallet( ${ id } ) );">Select</a>
                                                            <a class="dropdown-item" href="javascript:void( open_update_wallet( ${ id } ) );">Update</a>
                                                            <a class="dropdown-item" href="javascript:void( open_delete_wallet( ${ id } ) );">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    `; 
                    all_element += element;
                } );
                container.html( all_element );
            }
            return res;
        },
        error: ( err ) => {
            Toast.fire( {
                icon : 'error',
                title: 'Read All Wallet Error'
            } );
        }
    } );
}

function read_wallet() {
    const read_url = `${ api_url }wallet/read.php`;
    const id = wallet_record.find( '#id' ).val();
    // const id = 1;
    const sent_data = { id };
    $.ajax( {
        type    : 'POST',
        url     : read_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log(res);
            if ( res.result ) {
                const data = res.data;
                const { name, category, amount } = data;
                wallet_record.find( '#name' ).val( name );
                wallet_record.find( '#category' ).val( category );
                wallet_record.find( '#amount' ).val( amount );
            }
            return res;
        },
        error: ( err ) => {
            Toast.fire( {
                icon : 'error',
                title: 'Read Wallet Error'
            } );
        }
    } );
}

function create_wallet() {
    const create_url = `${ api_url }wallet/create.php`;
    const name          = wallet_record.find( '#name' ).val();
    const category = wallet_record.find( '#category' ).val();
    const fk_wallet_id     = wallet_record.find( '#id' ).val();
    const fk_user_id     = wallet_record.find( '#user-id' ).val();
    const status         = wallet_record.find( '#status' ).val();
    const amount         = wallet_record.find( '#amount' ).val();
    const sent_data = { name, category, fk_wallet_id, fk_user_id, status, amount };
    $.ajax( {
        type    : 'POST',
        url     : create_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log(res);
            if ( res.result ) {
                // open_manage_wallet_modal();
                close_wallet_modal();
                refresh();
                Toast.fire( {
                    icon : 'success',
                    title: 'Create Wallet Success'
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

function update_wallet() {
    const update_url = `${ api_url }wallet/update.php`;
    const id             = wallet_record.find( '#id' ).val();
    const name     = wallet_record.find( '#name' ).val();
    const category = wallet_record.find( '#category' ).val();
    const amount   = wallet_record.find( '#amount' ).val();
    const fk_wallet_id = wallet_record.find( '#id' ).val();
    const sent_data = { id, name, category, fk_wallet_id, amount };
    $.ajax( {
        type    : 'POST',
        url     : update_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log(res);
            if ( res.result ) {
                open_manage_wallet_modal();
                close_wallet_modal();
                refresh();
                Toast.fire( {
                    icon : 'success',
                    title: 'Update Wallet Success'
                } );
            }
            return res;
        },
        error: ( err ) => {
            Toast.fire( {
                icon : 'error',
                title: 'Update Wallet Error'
            } );
        }
    } );
}

function delete_wallet() {
    const id = wallet_record_delete.find( '#id' ).val();
    const delete_url = `${ api_url }wallet/delete.php`;
    const sent_data = { id };
    $.ajax( {
        type    : 'POST',
        url     : delete_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            console.log(res);
            if ( res.result ) {
                open_manage_wallet_modal();
                close_wallet_delete_modal();
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

$( '#wallet-record-form' ).submit( ( event ) => {
    event.preventDefault();
    if ( wallet_record.find( '#modal-header-title' ).text() == 'Add Wallet' ) {
        create_wallet();
    } else {
        update_wallet();
    }
    console.log( "create" );
} );

function get_date( date ) {
    var new_date = new Date( date );
    var formattedDate = new_date.getFullYear() + "-" + ( new_date.getMonth() + 1 ).toString().padStart( 2, "0" ) + "-" + new_date.getDate().toString().padStart( 2, "0" );
    return formattedDate;
} 

function update_select_date( value ) {
    $( '#select-date' ).val( value );
    $( '#select-date-label' ).html( value );
    refresh();
}

function refresh() {
    read_all_finance();
    read_finance_summary();
    read_finance_category_summary();
    
    read_wallet_summary();
}

refresh();