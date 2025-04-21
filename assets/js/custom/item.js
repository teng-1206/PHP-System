const item_record        = $( '#m-item-record' );
const item_record_delete = $( '#m-item-delete-record' );
const item_image         = $( '#m-item-image' );

// ! Item

function reset_item_modal() {
    item_record.find( '#name' ).val( '' );
    item_record.find( '#description' ).val( '' );
    item_record.find( '#status' ).prop( 'selectedIndex', 1 );
    item_record.find( '#purchase-date' ).val( get_current_day() );
    item_record.find( '#broken-date' ).val( get_current_day() );
    item_record.find( '#amount' ).val( '' );
    item_record.find( '#image' ).val( '' );
    change_state_broken_date( item_record.find( '#status' ).val() );
}

/**
 * Opens the item modal and resets its form.
 */
function open_item_modal() {
    reset_item_modal();
    item_record.modal( 'show' );
}

/**
 * Closes the item modal.
 */
function close_item_modal() {
    item_record.modal( 'hide' );
}

/**
 * Closes the delete item modal.
 */
function close_item_delete_modal() {
    item_record_delete.modal( 'hide' );
}

/**
 * Opens the item modal with a header title for adding a new item record.
 */
function open_create_item() {
    item_record.find( '#modal-header-title' ).text( 'Add Item' );
    open_item_modal();
}

/**
 * Opens the item modal with a header title for editing an existing item record.
 * @param {string} id - The ID of the item record to edit.
 */
function open_update_item( id ) {
    item_record.find( '#modal-header-title' ).text( 'Edit Item' );
    item_record.find( '#id' ).val( id );
    open_item_modal();
    read_item();
}

/**
 * Opens the delete item modal for the specified item record ID.
 * @param {string} id - The ID of the item record to delete.
 */
function open_delete_item( id ) {
    item_record_delete.modal( 'show' );
    item_record_delete.find( '#id' ).val( id );
}


$( '#item-record-form' ).submit( ( event ) => {
    event.preventDefault();
    if ( item_record.find( '#modal-header-title' ).text() == 'Add Item' ) {
        create_item();
    } else {
        update_item();
    }
} );

/**
 * Update the broken date required and disabled attribute when change the status.
 */
item_record.find( '#status' ).change( function() {
    change_state_broken_date( $( this ).val() );
});



const table = $( '#table-item' ).DataTable( {
    // headerCallback:function( e, a, t, n, s ) {
    //     e.getElementsByTagName( "th" )[ 0 ].innerHTML='<label class="new-control new-checkbox checkbox-outline-info m-auto">\n<input type="checkbox" class="new-control-input chk-parent select-customers-info" id="customer-all-info">\n<span class="new-control-indicator"></span><span style="visibility:hidden">c</span>\n</label>'
    // },
    columnDefs:[ {
        targets:0, width:"30px", className:"", orderable:5, render:function(e, a, t, n) {
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
// multiCheck( table );

function read_item_summary() {
    $( '.item-summary-widget' ).block( {
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
    const summary_url  = `${ api_url }item/summary.php`;
    const fk_user_id   = item_record.find( '#user-id' ).val();
    const sent_data    = { fk_user_id };
    $.ajax( {
        type    : 'POST',
        url     : summary_url,
        data: sent_data,
        dataType: 'JSON',
        success: ( res ) => {
            if ( res.result ) {
                const data = res.data;
                const { total_value } = data;
                $( '#total-value' ).html( total_value );
                $('.item-summary-widget').unblock();
            }
            return res;
        },
        error: ( err ) => {
            Toast.fire( {
                icon : 'error',
                title: 'Read Summary Error'
            } );
        }
    } );
}


function read_all_item() {
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
    const read_all_url = `${ api_url }item/read_all.php`;
    const fk_user_id   = item_record.find( '#user-id' ).val();
    const sent_data    = { fk_user_id };
    $.ajax( {
        type    : 'POST',
        url     : read_all_url,
        data: sent_data,
        dataType: 'JSON',
        success: ( res ) => {
            if ( res.result ) {
                // console.log(res);
                const data = res.data;
                if ( data.length > 0 ) {
                    data.forEach( ( row_data ) => {
                        const { id, name, purchase_date, broken_date, status, amount, image_url, thumb_image_url } = row_data;
                        let days;
                        if ( status == "No Available" ) {
                            days = get_days( purchase_date, broken_date );
                        } else {
                            days = get_days( purchase_date );
                        }
                        
                        table.row.add( [
                            `<td class="checkbox-column"> ${ id } </td>`,
                            `<img class="image-thumb" src="${ thumb_image_url }" data-full-src="${ image_url }" onclick="open_item_image_modal( this )" />`,
                            `${ name }`,
                            `<span class="${ status == "Available" ? 'text-success' : 'text-danger' }">${ status }</span>`,
                            `${ get_days_in_string( days ) }`,
                            `RM ${ amount }`,
                            `RM ${calculate_daily_value(amount, days)}`,
                            `${ get_date( purchase_date ) }`,
                            `
                            <button onclick="open_update_item( ${ id } );" class="btn btn-primary rounded-pill" data-toggle="tooltip" data-placement="top" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <button onclick="open_delete_item( ${ id } )" class="btn btn-danger rounded-pill" data-toggle="tooltip" data-placement="top" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            </button>
                            `,
                        ] ).draw( false );
                    } );
                }
                table.order( 7 ).draw()
            }
            $( '#table-area' ).unblock();
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

function read_item() {
    const read_url  = `${ api_url }item/read.php`;
    const id        = item_record.find( '#id' ).val();
    const sent_data = { id };
    $.ajax( {
        type    : 'POST',
        url     : read_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            // console.log(res);
            if ( res.result ) {
                const data = res.data;
                const { id, name, description, status, amount, purchase_date, broken_date  } = data;
                item_record.find( '#name' ).val( name );
                item_record.find( '#description' ).val( description );
                item_record.find( '#status' ).val( status );
                item_record.find( '#amount' ).val( amount );
                item_record.find( '#purchase-date' ).val( get_date( purchase_date ) );
                change_state_broken_date( status, broken_date );
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

function create_item() {
    const create_url    = `${ api_url }item/create.php`;
    // const name          = item_record.find( '#name' ).val();
    // const description   = item_record.find( '#description' ).val();
    // const purchase_date = item_record.find( '#purchase-date' ).val();
    // const broken_date   = item_record.find( '#broken-date' ).val();
    // const status        = item_record.find( '#status' ).val();
    // const amount        = item_record.find( '#amount' ).val();
    // const image         = item_record.find( '#image' )[ 0 ];
    // const fk_user_id    = item_record.find( '#user-id' ).val();

    let formData = new FormData();

    const image = item_record.find('#image')[0];
    if (image && image.files.length > 0) {
        formData.append('image', image.files[0]);
    }
    
    formData.append('name', item_record.find('#name').val() || '');
    formData.append('description', item_record.find('#description').val() || '');
    formData.append('purchase_date', item_record.find('#purchase-date').val() || '');
    formData.append('broken_date', item_record.find('#broken-date').val() || '');
    formData.append('status', item_record.find('#status').val() || '');
    formData.append('amount', item_record.find('#amount').val() || '');
    formData.append('fk_user_id', item_record.find('#user-id').val() || '');

    $.ajax( {
        type    : 'POST',
        url     : create_url,
        processData: false,
        contentType: false,    
        dataType: 'JSON',
        data    : formData,
        success: ( res ) => {
            // console.log(res);
            if ( res.result ) {
                close_item_modal();
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

function update_item() {
    const update_url    = `${ api_url }item/update.php`;
    // const id            = item_record.find( '#id' ).val();
    // const name          = item_record.find( '#name' ).val();
    // const description   = item_record.find( '#description' ).val();
    // const purchase_date = item_record.find( '#purchase-date' ).val();
    // const broken_date   = item_record.find( '#broken-date' ).val();
    // const status        = item_record.find( '#status' ).val();
    // const amount        = item_record.find( '#amount' ).val();
    // const fk_user_id    = item_record.find( '#user-id' ).val();

    let formData = new FormData();

    const image = item_record.find('#image')[0];
    if (image && image.files.length > 0) {
        formData.append('image', image.files[0]);
    }
    
    formData.append('id', item_record.find('#id').val() || '');
    formData.append('name', item_record.find('#name').val() || '');
    formData.append('description', item_record.find('#description').val() || '');
    formData.append('purchase_date', item_record.find('#purchase-date').val() || '');
    formData.append('broken_date', item_record.find('#broken-date').val() || '');
    formData.append('status', item_record.find('#status').val() || '');
    formData.append('amount', item_record.find('#amount').val() || '');
    formData.append('fk_user_id', item_record.find('#user-id').val() || '');

    // const sent_data     = { id, name, description, purchase_date, broken_date, status, amount, fk_user_id };
    $.ajax( {
        type    : 'POST',
        url     : update_url,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        data    : formData,
        success: ( res ) => {
            // console.log(res);
            if ( res.result ) {
                close_item_modal();
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

function delete_item() {
    const id         = item_record_delete.find( '#id' ).val();
    const delete_url = `${ api_url }item/delete.php`;
    const sent_data  = { id };
    $.ajax( {
        type    : 'POST',
        url     : delete_url,
        dataType: 'JSON',
        data    : sent_data,
        success: ( res ) => {
            // console.log(res);
            if ( res.result ) {
                close_item_delete_modal();
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

function change_state_broken_date( status, broken_date = get_current_day() ) {
    if ( status == "No Available" ) {
        item_record.find( '#broken-date' ).prop( 'required', true );
        item_record.find( '#broken-date' ).removeAttr( "disabled" );
        item_record.find( '#broken-date' ).val( get_date( broken_date ) );
    } else {
        item_record.find( '#broken-date' ).attr( 'disabled', 'disabled' );
        item_record.find( '#broken-date' ).removeAttr( "required" );
        item_record.find( '#broken-date' ).val( "" );
    }
}

function get_days( start_date, end_date = get_current_day() ) {
    start_date = new Date( start_date );
    end_date   = new Date( end_date );
    let timeDiff = end_date.getTime() - start_date.getTime();
    let days = Math.ceil( timeDiff / ( 1000 * 3600 * 24 ) );
    return days;
}

function get_days_in_string( days ) {
    const years = Math.floor( days / 365 );
    const remainingDays = days % 365;
    const months = Math.floor( remainingDays / 30 );
    const remainingDaysFinal = remainingDays % 30;
    let result = '';
    if ( years > 0 ) {
        result += years + ( years === 1 ? ' year ' : ' years ' );
    }
    if ( months > 0 ) {
        result += months + ( months === 1 ? ' month ' : ' months ' );
    }
    if ( remainingDaysFinal > 0 ) {
        result += remainingDaysFinal + ( remainingDaysFinal === 1 ? ' day ' : ' days ' );
    }
    return result.trim();
}

function get_date( date ) {
    var new_date = new Date( date );
    var formattedDate = new_date.getFullYear() + "-" + ( new_date.getMonth() + 1 ).toString().padStart( 2, "0" ) + "-" + new_date.getDate().toString().padStart( 2, "0" );
    return formattedDate;
} 

function calculate_daily_value(amount, days) {
    if ( days <= 0 ) {
        return amount;
    }
    const daily_value = amount / days;
    return daily_value.toFixed( 2 ); // rounded to 2 decimal places
}

function open_item_image_modal( element ) {
    const full_src = $( element ).data( 'full-src' );
    item_image.find( '#preview-image' ).attr( 'src', full_src );
    item_image.modal( 'show' );
}

function refresh() {
    read_all_item();
    read_item_summary();
    var firstUpload = new FileUploadWithPreview( 'file-preview-image' )
}

refresh();