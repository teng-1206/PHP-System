<?php include_once( realpath( dirname( __FILE__ ) . "//assets//config//config.php" ) ); ?>
<?php include_once( TEMPLATES_PATH . 'validation.php' ); ?>
<?php include_once( MODULES_PATH . 'user.php' ); ?>
<?php
    $user_controller = new User_Controller();
    $user = new User();
    $user->set( 'id', $_SESSION[ 'user_id' ] );
    $user = $user_controller->read( $conn2, $user );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Dashboard </title>
    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'plugins' ] . "apex/apexcharts.css"; ?>" />
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'css' ] . "dashboard/dash_1.css"; ?>" />
    <!-- Custom CSS End -->
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
                                <li class="breadcrumb-item active" aria-current="page"><span>Dashboard</span></li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!-- Breadcrumb End -->

    <input type="hidden" id="m-user-id" name="m-user-id" value="<?= $user->get( 'id' ) ?>">

    <!-- Main Container Start -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!-- Sidebar Start  -->
        <?php include_once( TEMPLATES_PATH . 'sidebar.php' ); ?>
        <!-- Sidebar End  -->
        
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
                    <!-- Revenue Chart Start -->
                    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div id="revenue-widget" class="widget widget-chart-one">
                            <div class="widget-heading">
                                <h5 class="">2023 Revenue</h5>
                                <div class="task-action">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                            <a class="dropdown-item" href="javascript:void( loading('This Week') );">Week</a>
                                            <a class="dropdown-item" href="javascript:void( loading('This Month') );">Month</a>
                                            <a class="dropdown-item" href="javascript:void( loading('This Year') );">Year</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content">
                                <div id="revenue">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Revenue Chart End -->
                    <!-- Expenses Category Start -->
                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div id="expenses-category-widget" class="widget widget-chart-two">
                            <div class="widget-heading">
                                <h5 class="">Expenses by Category</h5>
                            </div>
                            <div class="widget-content">
                                <div id="expenses-category"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Expenses Category End -->
                    <!-- Recent Income Table Start -->
                    <!-- <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">

                            <div class="widget-heading">
                                <h5 class="">Recent Orders</h5>
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Customer</div></th>
                                                <th><div class="th-content">Product</div></th>
                                                <th><div class="th-content">Invoice</div></th>
                                                <th><div class="th-content th-heading">Price</div></th>
                                                <th><div class="th-content">Status</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="td-content customer-name"><img src="assets/img/90x90.jpg" alt="avatar"><span>Luke Ivory</span></div></td>
                                                <td><div class="td-content product-brand text-primary">Headphone</div></td>
                                                <td><div class="td-content product-invoice">#46894</div></td>
                                                <td><div class="td-content pricing"><span class="">$56.07</span></div></td>
                                                <td><div class="td-content"><span class="badge badge-success">Paid</span></div></td>
                                            </tr>
                                            
                                            <tr>
                                                <td><div class="td-content customer-name"><img src="assets/img/90x90.jpg" alt="avatar"><span>Andy King</span></div></td>
                                                <td><div class="td-content product-brand text-warning">Nike Sport</div></td>
                                                <td><div class="td-content product-invoice">#76894</div></td>
                                                <td><div class="td-content pricing"><span class="">$88.00</span></div></td>
                                                <td><div class="td-content"><span class="badge badge-primary">Shipped</span></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="td-content customer-name"><img src="assets/img/90x90.jpg" alt="avatar"><span>Laurie Fox</span></div></td>
                                                <td><div class="td-content product-brand text-danger">Sunglasses</div></td>
                                                <td><div class="td-content product-invoice">#66894</div></td>
                                                <td><div class="td-content pricing"><span class="">$126.04</span></div></td>
                                                <td><div class="td-content"><span class="badge badge-success">Paid</span></div></td>
                                            </tr>                                            
                                            <tr>
                                                <td><div class="td-content customer-name"><img src="assets/img/90x90.jpg" alt="avatar"><span>Ryan Collins</span></div></td>
                                                <td><div class="td-content product-brand text-warning">Sport</div></td>
                                                <td><div class="td-content product-invoice">#89891</div></td>
                                                <td><div class="td-content pricing"><span class="">$108.09</span></div></td>
                                                <td><div class="td-content"><span class="badge badge-primary">Shipped</span></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="td-content customer-name"><img src="assets/img/90x90.jpg" alt="avatar"><span>Irene Collins</span></div></td>
                                                <td><div class="td-content product-brand text-primary">Speakers</div></td>
                                                <td><div class="td-content product-invoice">#75844</div></td>
                                                <td><div class="td-content pricing"><span class="">$84.00</span></div></td>
                                                <td><div class="td-content"><span class="badge badge-danger">Pending</span></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="td-content customer-name"><img src="assets/img/90x90.jpg" alt="avatar"><span>Sonia Shaw</span></div></td>
                                                <td><div class="td-content product-brand text-danger">Watch</div></td>
                                                <td><div class="td-content product-invoice">#76844</div></td>
                                                <td><div class="td-content pricing"><span class="">$110.00</span></div></td>
                                                <td><div class="td-content"><span class="badge badge-success">Paid</span></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                    <!-- Recent Income Table End -->
                    <!-- Recent Expense Table Start -->
                    <!-- <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-three">

                            <div class="widget-heading">
                                <h5 class="">Top Selling Product</h5>
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table table-scroll">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Product</div></th>
                                                <th><div class="th-content th-heading">Price</div></th>
                                                <th><div class="th-content th-heading">Discount</div></th>
                                                <th><div class="th-content">Sold</div></th>
                                                <th><div class="th-content">Source</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="td-content product-name"><img src="assets/img/90x90.jpg" alt="product"><div class="align-self-center"><p class="prd-name">Headphone</p><p class="prd-category text-primary">Digital</p></div></div></td>
                                                <td><div class="td-content"><span class="pricing">$168.09</span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing">$60.09</span></div></td>
                                                <td><div class="td-content">170</div></td>
                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> Direct</a></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="td-content product-name"><img src="assets/img/90x90.jpg" alt="product"><div class="align-self-center"><p class="prd-name">Shoes</p><p class="prd-category text-warning">Faishon</p></div></div></td>
                                                <td><div class="td-content"><span class="pricing">$108.09</span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing">$47.09</span></div></td>
                                                <td><div class="td-content">130</div></td>
                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> Google</a></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="td-content product-name"><img src="assets/img/90x90.jpg" alt="product"><div class="align-self-center"><p class="prd-name">Watch</p><p class="prd-category text-danger">Accessories</p></div></div></td>
                                                <td><div class="td-content"><span class="pricing">$88.00</span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing">$20.00</span></div></td>
                                                <td><div class="td-content">66</div></td>
                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> Ads</a></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="td-content product-name"><img src="assets/img/90x90.jpg" alt="product"><div class="align-self-center"><p class="prd-name">Laptop</p><p class="prd-category text-primary">Digital</p></div></div></td>
                                                <td><div class="td-content"><span class="pricing">$110.00</span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing">$33.00</span></div></td>
                                                <td><div class="td-content">35</div></td>
                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> Email</a></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="td-content product-name"><img src="assets/img/90x90.jpg" alt="product"><div class="align-self-center"><p class="prd-name">Camera</p><p class="prd-category text-primary">Digital</p></div></div></td>
                                                <td><div class="td-content"><span class="pricing">$126.04</span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing">$26.04</span></div></td>
                                                <td><div class="td-content">30</div></td>
                                                <td><div class="td-content"><a href="javascript:void(0);" class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> Referral</a></div></td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>  -->
                    <!-- Recent Expense Table End -->
                </div>
            </div>
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

    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "apex/apexcharts.min.js"; ?>"></script>
    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "blockui/jquery.blockUI.min.js"; ?>"></script>

    <script src="<?= '' // $config[ 'urls' ][ 'js' ] . "custom/dashboard.js"; ?>"></script>

    <script>
        Apex.tooltip = {
            theme: 'dark'
        }
        /*
            =================================
                Revenue Monthly | Options
            =================================
        */
        var revenue_chart = null;
        function load_revenue( select_date ) {
            $( '#revenue-widget' ).block( {
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
            revenue_chart != null ? revenue_chart.destroy() : null;
            const revenue_url = `${ api_url }finance/revenue.php`;
            const fk_user_id = $( '#m-user-id' ).val();
            const sent_data = { fk_user_id, select_date };

            $.ajax( {
                type    : 'POST',
                url     : revenue_url,
                data: sent_data,
                dataType: 'JSON',
                success: ( res ) => {
                    if ( res.result ) {
                        // console.log( res.data );
                        display_revenue( res.data );
                        $('#revenue-widget').unblock();
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Read Revenue Error'
                    } );
                }
            } );
        }

        function display_revenue( data ) {
            const { income, expense, label } = data;
            var option = {
                chart: {
                    fontFamily: 'Nunito, sans-serif',
                    height: 365,
                    type: 'area',
                    zoom: {
                        enabled: false
                    },
                    dropShadow: {
                        enabled: true,
                        opacity: 0.2,
                        blur: 10,
                        left: -7,
                        top: 22
                    },
                    toolbar: {
                        show: false
                    },
                    events: {
                        mounted: function( ctx, config ) {
                            const highest1 = ctx.getHighestValueInSeries(0);
                            const highest2 = ctx.getHighestValueInSeries(1);
                            ctx.addPointAnnotation({
                                x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
                                y: highest1,
                                label: {
                                style: {
                                    cssClass: 'd-none'
                                }
                                },
                                customSVG: {
                                    SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#2196f3" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                                    cssClass: undefined,
                                    offsetX: -8,
                                    offsetY: 5
                                }
                            })
                            ctx.addPointAnnotation({
                                x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
                                y: highest2,
                                label: {
                                style: {
                                    cssClass: 'd-none'
                                }
                                },
                                customSVG: {
                                    SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                                    cssClass: undefined,
                                    offsetX: -8,
                                    offsetY: 5
                                }
                            })
                        },
                    }
                },
                colors: [ '#2196f3', '#e7515a' ],
                dataLabels: {
                    enabled: false
                },
                markers: {
                    discrete: [{
                    seriesIndex: 0,
                    dataPointIndex: 7,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 5
                    }, {
                    seriesIndex: 2,
                    dataPointIndex: 11,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 4
                    }]
                },
                subtitle: {
                    text    : '0',
                    align   : 'left',
                    margin  : 0,
                    offsetX : 95,
                    offsetY : 0,
                    floating: false,
                    style   : {
                        fontSize: '18px',
                        color   : '#4361ee'
                    }
                },
                title: {
                    text: 'Total Earning',
                    align: 'left',
                    margin: 0,
                    offsetX: -10,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize: '18px',
                        color:  '#bfc9d4'
                    },
                },
                stroke: {
                    show: true,
                    curve: 'smooth',
                    width: 2,
                    lineCap: 'square'
                },
                series: [
                    {
                        name: 'Income',
                        data: income
                    },
                    {
                        name: 'Expense',
                        data: expense
                    }
                ],
                labels: label,
                xaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        show: true
                    },
                    labels: {
                        offsetX: 0,
                        offsetY: 5,
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Nunito, sans-serif',
                            cssClass: 'apexcharts-xaxis-title',
                        },
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(value, index) {
                            // return (value / 1000) + 'K'
                            return value
                        },
                        offsetX: -22,
                        offsetY: 0,
                        // decimalsInFloat: 2,
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Nunito, sans-serif',
                            cssClass: 'apexcharts-yaxis-title',
                        },
                    }
                },
                grid: {
                    borderColor: '#191e3a',
                    strokeDashArray: 5,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },   
                    yaxis: {
                        lines: {
                            show: false,
                        }
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: -10
                    }, 
                }, 
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -50,
                    fontSize: '16px',
                    fontFamily: 'Quicksand, sans-serif',
                    markers: {
                        width: 10,
                        height: 10,
                        strokeWidth: 0,
                        strokeColor: '#fff',
                        fillColors: undefined,
                        radius: 12,
                        onClick: undefined,
                        offsetX: 0,
                        offsetY: 0
                    },    
                    itemMargin: {
                        horizontal: 0,
                        vertical: 20
                    }
                },
                tooltip: {
                    theme: 'dark',
                    marker: {
                        show: true,
                    },
                    x: {
                        show: false,
                    }
                },
                fill: {
                    type:"gradient",
                    gradient: {
                        type: "vertical",
                        shadeIntensity: 1,
                        inverseColors: !1,
                        opacityFrom: .19,
                        opacityTo: .05,
                        stops: [100, 100]
                    }
                },
                responsive: [{
                    breakpoint: 575,
                    options: {
                        legend: {
                            offsetY: -30,
                        },
                    },
                }]
            }

            revenue_chart = new ApexCharts(
                document.querySelector( "#revenue" ),
                option
            );
            revenue_chart.render();
        }

        

        /*
            ==================================
                Sales By Category | Options
            ==================================
        */
        var expenses_category_chart = null;
        function generateRandomColor(){
            let maxVal = 0xFFFFFF; // 16777215
            let randomNumber = Math.random() * maxVal; 
            randomNumber = Math.floor(randomNumber);
            randomNumber = randomNumber.toString(16);
            let randColor = randomNumber.padStart(6, 0);   
            return `#${randColor.toUpperCase()}`
        }

        function load_category( select_date ) {
            $( '#expenses-category-widget' ).block( {
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
            expenses_category_chart != null ? expenses_category_chart.destroy() : null;
            const summary_url = `${ api_url }finance_category/summary.php`;
            const fk_user_id = $( '#m-user-id' ).val();
            const sent_data = { fk_user_id, select_date };
            $.ajax( {
                type    : 'POST',
                url     : summary_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    if ( res.result ) {
                        console.log( res.data );
                        res.data.length > 0 ? display_category( res.data ) : null;
                        $('#expenses-category-widget').unblock();
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

        function display_category( data ) {
            expenses = [];
            labels = [];
            colors = [];
            for ( let i = 0; i < data.length; i++  ) {
                const { category, expense } = data[ i ];
                if ( expense != '0.00' ) {
                    expenses.push( Number.parseFloat( expense ) );
                    labels.push( category );
                    colors.push( generateRandomColor() )
                }
            }
            var options = {
                chart: {
                    type: 'donut',
                    width: 380
                },
                colors: colors,
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '10px',
                    markers: {
                        width: 10,
                        height: 10,
                    },
                    itemMargin: {
                        horizontal: 4,
                        vertical: 8
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '80%',
                            background: 'transparent',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '20px',
                                    fontFamily: 'Nunito, sans-serif',
                                    color: undefined,
                                    offsetY: -10
                                },
                                value: {
                                    show: true,
                                    fontSize: '18px',
                                    fontFamily: 'Nunito, sans-serif',
                                    color: '#bfc9d4',
                                    offsetY: 16,
                                    formatter: function (val) {
                                        return Number.parseFloat( val );
                                    }
                                },
                                total: {
                                    show: true,
                                    showAlways: true,
                                    label: 'Total',
                                    color: '#888ea8',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce( function(a, b) {
                                            return ( a + b );
                                        }, 0)
                                    }
                                }
                            }
                        }
                    }
                },
                stroke: {
                    show: true,
                    width: 6,
                    colors: '#0e1726'
                },
                series: expenses,
                labels: labels,
                responsive: [{
                    breakpoint: 1599,
                    options: {
                        chart: {
                            width: '350px',
                            height: '400px'
                        },
                        legend: {
                            position: 'bottom'
                        }
                    },
                    breakpoint: 1439,
                    options: {
                        chart: {
                            width: '250px',
                            height: '390px'
                        },
                        legend: {
                            position: 'bottom'
                        },
                        plotOptions: {
                            pie: {
                            donut: {
                                size: '65%',
                            }
                            }
                        }
                    },
                }]
            }

            expenses_category_chart = new ApexCharts(
                document.querySelector( "#expenses-category" ),
                options
            );
            expenses_category_chart.render();
        }

        function loading( select_date ) {
            load_revenue( select_date );
            load_category( select_date );
        }

        loading( 'This Week' );
        
    </script>
</body>
</html>