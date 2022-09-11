function open_modal() {
    reset_modal();
    $( '#m-wallet' ).modal( 'show' );
}

function close_modal() {
    $( '#m-wallet' ).modal( 'hide' );
}

function close_delete_modal() {
    $( '#m-wallet-delete' ).modal( 'hide' );
}

function reset_modal() {
    $( '#m-name' ).val( '' );
    $( '#m-amount' ).val( '' );
}

function open_create_wallet() {
    $( '#modal-header-title' ).text( 'Add Wallet' );
    open_modal();
}

function open_update_wallet( id ) {
    $('#modal-header-title').text( 'Edit Wallet' );
    $( '#m-id' ).val( id );
    open_modal();
    read_wallet();
}

function open_delete_wallet( id ) {
    $( '#m-wallet-delete' ).modal( 'show' );
    $( '#m-id-delete' ).val( id );
}

$( '#wallet-form' ).submit( ( event ) => {
    event.preventDefault();
    if ( $( '#modal-header-title' ).text() == 'Add Wallet' ) {
        create_wallet();
    } else {
        update_wallet();
    }
    
} );

const table = $( '#table-wallet' ).DataTable( {
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
            "sSearchPlaceholder": "Search...",
        "sLengthMenu": "Results :  _MENU_",
        },
        "lengthMenu": [ 10, 20, 50 ],
        "pageLength": 10 
    } );
multiCheck( table );

// CRUD Function
function read_all_wallet() {
    table.clear().draw();
    const read_all_url = `${ api_url }wallet/read_all.php`;
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
                        const { id, name, amount } = row_data;
                        table.row.add( [
                            `<td class="checkbox-column"> 1 </td>`,
                            `${ name }`,
                            `${ amount }`,
                            `
                            <button onclick="open_update_wallet( ${ id } );" class="btn btn-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <button onclick="open_delete_wallet( ${ id } )" class="btn btn-danger rounded-pill" data-toggle="tooltip" data-placement="top" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            </button>
                            `,
                        ] ).draw( false );
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

function read_wallet() {
    const read_url = `${ api_url }wallet/read.php`;
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
                const { name, amount } = data;
                $( '#m-name' ).val( name );
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

function create_wallet() {
    const create_url = `${ api_url }wallet/create.php`;
    const fk_user_id = $( '#m-user-id' ).val();
    const name       = $( '#m-name' ).val();
    const amount     = $( '#m-amount' ).val();
    const sent_data = { fk_user_id, name, amount };
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

function update_wallet() {
    const update_url = `${ api_url }wallet/update.php`;
    const id     = $( '#m-id' ).val();
    const name   = $( '#m-name' ).val();
    const amount = $( '#m-amount' ).val();
    const sent_data = { id, name, amount };
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

function delete_wallet() {
    const id = $( '#m-id-delete' ).val();
    const delete_url = `${ api_url }wallet/delete.php`;
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
    read_all_wallet();
}

refresh();