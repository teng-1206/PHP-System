const item_record                 = $( '#m-item-record' );
const item_record_delete          = $( '#m-item-delete-record' );

// ! Item

function reset_item_modal() {
    item_record.find( '#title' ).val( '' );
    item_record.find( '#date' ).val( get_current_day() );
    item_record.find( '#category' ).prop( 'selectedIndex', 0 );
    item_record.find( '#status' ).prop( 'selectedIndex', 2 );
    item_record.find( '#amount' ).val( '' );
}

function close_delete_modal() {
    $( '#m-finance-category-delete' ).modal( 'hide' );
}

function open_update_finance_category( id ) {
    $( '#modal-header-title' ).text( 'Edit Category' );
    $( '#m-id' ).val( id );
    read_finance_category();
}

function open_delete_finance_category( id ) {
    $( '#m-finance-category-delete' ).modal( 'show' );
    $( '#m-id-delete' ).val( id );
}

$( '#finance-category-form' ).submit( ( event ) => {
    event.preventDefault();
    if ( $( '#modal-header-title' ).text() == 'Add Category' ) {
        create_finance_category();
    } else {
        update_finance_category();
    }
    
} );

const table = $( '#table-finance-category' ).DataTable( {
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

// CRUD Functions
function read_all_finance_category() {
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
    const read_all_url = `${ api_url }finance_category/read_all.php`;
    const fk_user_id = $( '#m-user-id' ).val();
    const sent_data = { fk_user_id };
    $.ajax( {
        type    : 'POST',
        url     : read_all_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            if ( res.result ) {
                const data = res.data;
                if ( data.length > 0 ) {
                    data.forEach( ( row_data ) => {
                        const { id, category, color_code, background_color_code, icon_code } = row_data;
                        const index = table.rows().count() + 1;
                        table.row.add( [
                            `${ index }`,
                            // `<i class="${ icon_code } p-3 rounded-circle" style="color: ${ color_code }; background-color: ${ background_color_code }" width="25px" height="17px"></i>`,
                            `${ category }`,
                            `<button onclick="open_update_finance_category( ${ id } );" class="btn btn-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <button onclick="open_delete_finance_category( ${ id } )" class="btn btn-danger rounded-pill" data-toggle="tooltip" data-placement="top" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            </button>`,
                        ] ).draw( false );
                        table.order( [ 1, 'asc' ] ).draw();
                        $('#table-area').unblock();
                    } );
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
                const { category, color_code, background_color_code, icon_code } = data;
                $( '#m-category' ).val( category );
                $( '#m-color' ).val( color_code );
                $( '#m-background-color' ).val( background_color_code );
                $( '#m-icon' ).val( icon_code );
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
    const fk_user_id            = $( '#m-user-id' ).val();
    const category              = $( '#m-category' ).val();
    const color_code            = $( '#m-color' ).val();
    const background_color_code = $( '#m-background-color' ).val();
    const icon_code             = $( '#m-icon' ).val();
    const sent_data = { fk_user_id, category, color_code, background_color_code, icon_code };
    $.ajax( {
        type    : 'POST',
        url     : create_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            if ( res.result ) {
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
    const id                    = $( '#m-id' ).val();
    const category              = $( '#m-category' ).val();
    const color_code            = $( '#m-color' ).val();
    const background_color_code = $( '#m-background-color' ).val();
    const icon_code             = $( '#m-icon' ).val();
    const sent_data = { id, category, color_code, background_color_code, icon_code };
    $.ajax( {
        type    : 'POST',
        url     : update_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            if ( res.result ) {
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
    const id = $( '#m-id-delete' ).val();
    const delete_url = `${ api_url }finance_category/delete.php`;
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
    read_all_finance_category();
    reset_modal();
}

refresh();