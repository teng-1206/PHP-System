<?php
    // Current Page
    $current_page = basename( $_SERVER[ 'PHP_SELF' ] );

    // Dashboard
    $dashboard = array( 'dashboard.php' );
    $res_dashboard = in_array( $current_page, $dashboard );

    // Finance
    $finance = array( 'finance.php', 'finance-category.php' );
    $res_finance = in_array( $current_page, $finance );

    // Note
    
    // Task
    
    // Password Manager

?>
<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <!-- Dashboard Start -->
            <li class="menu">
                <a href="dashboard" data-active="<?= $res_dashboard ? 'true' : 'false' ?>" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span> Dashboard </span>
                    </div>
                </a>
            </li>
            <!-- Dashboard End -->

            <!-- Finance Start -->
            <li class="menu">
                <a href="#finance" data-active="<?= $res_finance ? 'true' : 'false' ?>" data-toggle="collapse" aria-expanded="<?= $res_finance ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span>Finance</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?= $res_finance ? 'show' : '' ?>" id="finance" data-parent="#accordionExample">
                    <li class="<?= $current_page == 'finance.php' ? 'active' : '' ?>">
                        <a href="finance"> Record </a>
                    </li>
                    <!-- <li>
                        <a href="finance-report"> Report </a>
                    </li> -->
                    <li class="<?= $current_page == 'finance-category.php' ? 'active' : '' ?>">
                        <a href="finance-category"> Category </a>
                    </li>
                </ul>
            </li>
            <!-- Finance End -->

        </ul>
        <!-- <div class="shadow-bottom"></div> -->
        
    </nav>

</div>