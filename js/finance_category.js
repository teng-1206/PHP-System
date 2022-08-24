function reset_modal() {
    $( '#m-category' ).val( '' );
    $( '#m-icon' ).val( '' );
    $( '#m-color' ).val( '' );
    $( '#m-background-color' ).val( '' );
}

function open_update_finance_category( id ) {
    $('#modal-header-title').text( 'Edit Category' );
    $( '#m-id' ).val( id );
    read_finance_category();
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
    dom:"<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'l <'dt-action-buttons align-self-center ml-2' B>><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f<'toolbar align-self-center'>>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
    buttons: [],
    columnDefs: [
        {"className": "align-middle", "targets": "_all"}
    ],
    order: [ [ 0, 'asc' ] ],
    oLanguage: {
        oPaginate         : { 'sPrevious': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        sInfo             : 'Showing Page _PAGE_ of _PAGES_',
        sSearch           : '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        sSearchPlaceholder: 'Search',
        sLengthMenu       : 'Results :  _MENU_',
    },
    stripeClasses: [],
    lengthMenu   : [ 10, 25, 50 ],
    pageLength   : 10
} );

// CRUD Functions
function read_all_finance_category() {
    table.clear().draw();
    const read_all_url = `${ api_url }finance_category/read_all.php`;
    const sent_data = {};
    $.ajax( {
        type    : 'GET',
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
                            `<i class="${ icon_code } p-3 rounded-circle" style="color: ${ color_code }; background-color: ${ background_color_code }" width="25px" height="17px"></i>`,
                            `${ category }`,
                            `<span class="button-hover rounded-circle" onclick="open_update_finance_category( ${ id } )">
                                <i class="fas fa-pen fa-lg"></i>
                            </span>
                            <span class="button-hover rounded-circle" onclick="delete_finance_category( ${ id } )">
                                <i class="fas fa-times-circle fa-lg"></i>
                            </span>`,
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
    const category              = $( '#m-category' ).val();
    const color_code            = $( '#m-color' ).val();
    const background_color_code = $( '#m-background-color' ).val();
    const icon_code             = $( '#m-icon' ).val();
    const sent_data = { category, color_code, background_color_code, icon_code };
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

function delete_finance_category( id ) {
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
            const delete_url = `${ api_url }finance_category/delete.php`;
            const sent_data = { id };
            $.ajax( {
                type    : 'POST',
                url     : delete_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
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
    } );
}

function refresh() {
    read_all_finance_category();
    reset_modal();
}

refresh();