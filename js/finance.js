function open_modal() {
    reset_modal();
    $( '#m-finance-record' ).modal( 'show' );
}

function close_modal() {
    $( '#m-finance-record' ).modal( 'hide' );
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

$( '#finance-record-form' ).submit( ( event ) => {
    event.preventDefault();
    if ( $( '#modal-header-title' ).text() == 'Add Finance' ) {
        create_finance();
    } else {
        update_finance();
    }
    
} );

// CRUD Functions
function read_finance_summary() {
    const summary_url = `${ api_url }finance/summary.php`;
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

function read_finance_category_summary() {
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
                        const padding_bottom = ( index == data.length ) ? "pb-0" : "";
                        const { id, category, income, expense } = row_data;
                        const element =   `
                                    <div class="card-body p-5 ${ padding_bottom }" >
                                        <div class="row">
                                            <small class="fw-bold fst-italic">${ category }</small><br/>
                                            <div class="col-6">
                                                <span class="fw-bold text-success">RM ${ income }</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="fw-bold text-danger">RM ${ expense }</span>
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
                title: 'Read Error'
            } );
        }
    } );
}

function read_all_finance() {
    let container = $( '#pagination' );
    container.pagination( {
        dataSource: function( done ) {
            const read_all_url = `${ api_url }finance/read_all.php`;
            const fk_user_id = $( '#m-user-id' ).val();
            const sent_data = { fk_user_id };
            $.ajax( {
                type    : 'POST',
                url     : read_all_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        done( res.data );
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
        },
        pageSize: 6,
        showNavigator: true,
        className: '',
        formatNavigator: '<span class="">Showing <span class="fw-bold"><%= currentPage %></span> of <span class="fw-bold"><%= totalPage %></span> pages | Total <span class="fw-bold"><%= totalNumber %></span> entries</span>',
        callback: function ( data, pagination ) {
            let all_element = '';
            $.each( data, function ( index, item ) {
                var element = `
                                <div class="card bg-white mb-3 shadow rounded-5">
                                    <div class="card-body" >
                                        <div class="row">
                                            <div class="col-1 text-center align-self-center">
                                                <i class="${ item[ 'icon_code' ] } p-3 rounded-circle" style="color: ${ item[ 'color_code' ] }; background-color: ${ item[ 'background_color_code' ] }" width="25px" height="17px"></i>
                                            </div>
                                            <div class="col-6">
                                                <h5>${ item[ 'title' ] }</h5>
                                                <small class="fw-light fst-italic">${ item[ 'create_at' ] }</small>
                                            </div>
                                            <div class="col-2 text-end align-self-center ${ item[ 'status' ] == 0 ? 'text-success' : 'text-danger' } fw-bold">
                                                ${ item[ 'status' ] == 0 ? '&#43;' : '&#45;' }  RM ${ item[ 'amount' ] }
                                            </div>
                                            <div class="col-3 text-end align-self-center">
                                                <span class="button-hover rounded-circle" onclick="open_update_finance( ${ item[ 'id' ] } )">
                                                    <i class="fas fa-pen fa-lg"></i>
                                                </span>
                                                <span class="button-hover rounded-circle" onclick="delete_finance( ${ item[ 'id' ] } )">
                                                    <i class="fas fa-times-circle fa-lg"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            all_element += element;
                
            });
            $( "#list" ).html( all_element );
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
    const fk_user_id     = $( '#m-user-id' ).val();
    const title          = $( '#m-title' ).val();
    const date           = $( '#m-date' ).val();
    const fk_category_id = $( '#m-category' ).val();
    const status         = $( '#m-status' ).val();
    const amount         = $( '#m-amount' ).val();
    const sent_data = { fk_user_id, title, date, fk_category_id, status, amount };
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

function delete_finance( id ) {
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
    read_all_finance();
    read_finance_summary();
    read_finance_category_summary();
}

refresh();