<?php include_once( realpath( dirname( __FILE__ ) . "//assets//config//config.php" ) ); ?>
<?php include_once( TEMPLATES_PATH . 'validation.php' ); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | Task </title>
    <!-- Global CSS Start -->
    <?php include_once( TEMPLATES_PATH . 'head.php' ); ?>
    <!-- Global CSS End -->

    <!-- Custom CSS Start -->
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'css' ] . "apps/scrumboard.css"; ?> ">
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'css' ] . "forms/theme-checkbox-radio.css"; ?> ">
    <link rel="stylesheet" type="text/css" href="<?= $config[ 'urls' ][ 'css' ] . "forms/switches.css"; ?> ">
    <!-- Custom CSS End -->

    <style>
        .task-list-container { min-width: 410px; }

        .task-list-section { padding-bottom: 20px; }

        .scroll-content-area { overflow-y: scroll; }
                
        .priority-dropdown {
            float: right;
            /* padding: 20px 10px 20px 10px; */
        }
        .priority-dropdown .dropdown-toggle { font-size: 20px; }
        .priority-dropdown .dropdown-toggle.danger svg {
            color: #e7515a;
            fill: rgba(231, 81, 90, 0.19);
        }
        .priority-dropdown .dropdown-toggle.warning svg {
            color: #e2a03f;
            fill: rgba(233, 176, 43, 0.19);
        }
        .priority-dropdown .dropdown-toggle.primary svg {
            color: #2196f3;
            fill: rgba(33, 150, 243, 0.19);
        }
        .priority-dropdown .dropdown-menu.show {
            top: 32px!important;
        }
        .priority-dropdown .dropdown-menu a.dropdown-item.active,
        .priority-dropdown .dropdown-menu a.dropdown-item:active { background: transparent; }
        .priority-dropdown .dropdown-menu a svg {
            font-size: 19px;
            font-weight: 700;
            margin-right: 7px;
            vertical-align: middle;
        }
        .priority-dropdown .dropdown-menu a.danger svg { color: #e7515a; }
        .priority-dropdown .dropdown-menu a.warning svg { color: #e2a03f; }
        .priority-dropdown .dropdown-menu a.primary svg { color: #2196f3; }
        .action-dropdown .dropdown-menu .permanent-delete { display: none; }
        .action-dropdown .dropdown-menu .revive { display: none; }
        .todo-inbox .todo-item.todo-task-trash .n-chk { display: none; }
        .todo-inbox .todo-item.todo-task-trash .todo-item-inner .todo-content {
            width: 100%;
            padding: 20px 14px 20px 14px;
        }
        .todo-inbox .todo-item.todo-task-trash .todo-item-inner .priority-dropdown .dropdown-menu { display: none; }
        .todo-inbox .todo-item.todo-task-trash .todo-item-inner .action-dropdown .dropdown-menu .edit { display: none; }
        .todo-inbox .todo-item.todo-task-trash .todo-item-inner .action-dropdown .dropdown-menu .important { display: none; }
        .todo-inbox .todo-item.todo-task-trash .todo-item-inner .action-dropdown .dropdown-menu .delete { display: none; }
        .todo-inbox .todo-item.todo-task-trash .todo-item-inner .action-dropdown .dropdown-menu .permanent-delete { display: block; }
        .todo-inbox .todo-item.todo-task-trash .todo-item-inner .action-dropdown .dropdown-menu .revive { display: block; }
        .action-dropdown .dropdown-menu.show {
            top: 32px!important;
        }
        .action-dropdown .dropdown-menu .dropdown-item.active,
        .action-dropdown .dropdown-menu .dropdown-item:active {
            background-color: transparent;
        }
        .action-dropdown {
            float: right;
            padding: 20px 10px 20px 10px;
        }
        .action-dropdown .dropdown-toggle svg {
            width: 21px;
            height: 21px;
            margin-top: 5px;
            color: #888ea8;
        }
        .action-dropdown .show .dropdown-toggle svg {
            color: #bfc9d4;
        }
    </style>
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
                                <li class="breadcrumb-item active" aria-current="page"><span>Task</span></li>
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
                    <div class="col-12">
                        <div class="action-btn layout-top-spacing mb-3">
                            <input type="hidden" id="fk-task-project-id" name="fk-task-project-id" value="1">
                            <button id="add-list" class="btn btn-primary">Add List</button>
                            <button id="add-list" class="btn btn-primary" onclick="open_add_task_modal()">Add Task</button>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Add Task Modal Start -->
                        <!-- <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="compose-box">
                                            <div class="compose-content" id="addTaskModalTitle">
                                                <h5 class="add-task-title">Add Task</h5>
                                                <h5 class="edit-task-title">Edit Task</h5>

                                                <div class="addTaskAccordion" id="add_task_accordion">
                                                    <div class="card task-text-progress">
                                                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#add_task_accordion">
                                                            <div class="card-body">
                                                                <form action="javascript:void(0);">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="task-title mb-4">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                                                <input id="s-task" type="text" placeholder="Task" class="form-control" name="task">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="task-badge">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                                                <textarea id="s-text" placeholder="Task Text" class="form-control" name="taskText"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Discard</button>
                                        <button data-btnfn="addTask" class="btn add-tsk">Add Task</button>
                                        <button data-btnfn="editTask" class="btn edit-tsk" style="display: none;">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- Add Task Modal End -->

                        <!-- Add / Edit Task Modal Start -->
                        <div class="modal fade back-blur-3" id="m-task" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" >
                                <div class="modal-content p-3 rounded-5">
                                    <div class="modal-header border-0">
                                        <h5 id="modal-header-title" class="modal-title"></h5>
                                        <div class="priority-dropdown custom-dropdown-icon">
                                            <div class="dropdown p-dropdown">
                                                <a class="dropdown-toggle" href="#" role="button" id="priority-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="priority-dropdown" style="will-change: transform;">
                                                    <a id="m-high-priority" class="dropdown-item text-danger" href="#" onclick="change_priority( 1 )"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon text-danger"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg> High</a>
                                                    <a id="m-middle-priority" class="dropdown-item text-warning" href="#" onclick="change_priority( 2 )"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon text-warning"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg> Middle</a>
                                                    <a id="m-low-priority" class="dropdown-item text-primary" href="#" onclick="change_priority( 3 )"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon text-primary"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg> Low</a>
                                                    <a id="m-none-priority" class="dropdown-item" href="#" onclick="change_priority( 0 )"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg> None</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form id="task-form">
                                            <input type="hidden" id="m-task-id" name="m-task-id" value="0">
                                            <input type="hidden" id="m-fk-task-order-id" name="m-fk-task-order-id" value="0">
                                            <input type="hidden" id="m-fk-task-priority-id" name="m-fk-task-priority-id" value="0">
                                            <input type="hidden" id="m-fk-task-reminder-id" name="m-fk-task-reminder-id" value="0">
                                            <div class="row ">
                                                <div class="col-12 mb-4">
                                                    <label for="m-task-title" class="form-label">Title</label>
                                                    <input type="text" id="m-task-title" name="m-task-title" class="form-control" placeholder="Title" autocomplete="off" required />
                                                </div>
                                                <div class="col-12 col-lg-12 mb-4">
                                                    <label for="m-task-description" class="form-label">Description</label>
                                                    <textarea name="m-task-description" id="m-task-description" class="form-control" cols="30" rows="5" placeholder="Description"></textarea>
                                                </div>
                                                <div class="col-12 col-lg-4 mb-4">
                                                    <label for="m-task-status" class="form-label">Status</label>
                                                    <select id="m-task-status" name="m-task-status" class="form-control" required >
                                                        <option value="" selected >Select Status</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-8 mb-4">
                                                    <label class="" for="">Due Date & Repeat</label>
                                                    <div class="input-group mb-4">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <label class="switch s-primary mb-0">
                                                                    <input type="checkbox" id="m-task-due-date-repeat" name="m-task-due-date-repeat" onchange="change_due_date_repeat()" >
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <input type="date" id="m-task-due-date" name="m-task-due-date" class="form-control" placeholder="DD/MM/YYYY" value="" disabled required>
                                                        <select id="m-fk-task-repeat-period-id" name="m-fk-task-repeat-period-id" class="form-control" disabled required >
                                                            <option value="0" selected >No Repeat</option>
                                                            <option value="1">Daily</option>
                                                            <option value="2">Weekly</option>
                                                            <option value="3">Yearly</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-4">
                                                    <div class="input-group mb-4">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <label class="switch s-primary mb-0">
                                                                    <input type="checkbox" id="m-task-reminder" name="m-task-reminder" onchange="change_reminder()">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Reminder</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button id="m-task-btn-cancel" name="m-task-btn-cancel" type="button" class="btn rounded-pill" onclick="close_task_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                        <button id="m-task-btn-delete" name="m-task-btn-delete" type="button" class="btn btn-danger rounded-pill" onclick="open_delete_task_modal()" style="width: 100px; height: 40px;">Delete</button>
                                        <button id="m-task-btn-submit" name="m-task-btn-add" type="submit" class="btn btn-primary rounded-pill" form="task-form" style="width: 120px; height: 40px;">Add Task</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add/ Edit Task Modal End -->

                        <!-- Edit Task Modal Start -->
                        <!-- <div class="modal fade back-blur-3" id="m-edit-task" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" >
                                <div class="modal-content p-3 rounded-5">
                                    <div class="modal-header border-0">
                                        <h5 id="modal-header-title" class="modal-title">Edit Task</h5>
                                        <div class="priority-dropdown custom-dropdown-icon">
                                            <div class="dropdown p-dropdown">
                                                <a class="dropdown-toggle" href="#" role="button" id="priority-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="priority-dropdown" style="will-change: transform;">
                                                    <a class="dropdown-item text-danger" href="#" onclick="change_priority( 1 )"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon text-danger"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg> High</a>
                                                    <a class="dropdown-item text-warning" href="#" onclick="change_priority( 2 )"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon text-warning"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg> Middle</a>
                                                    <a class="dropdown-item text-primary" href="#" onclick="change_priority( 3 )"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon text-primary"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg> Low</a>
                                                    <a id="m-low-priority" class="dropdown-item" href="#" onclick="change_priority( 0 )"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg> None</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit-task-form">
                                            <input type="hidden" id="m-edit-id" name="m-edit-id" value="">
                                            <input type="hidden" id="m-edit-fk-priority-id" name="m-edit-fk-priority-id" value="0">
                                            <input type="hidden" id="m-edit-fk-reminder-id" name="m-edit-fk-reminder-id" value="0">
                                            <div class="row ">
                                                <div class="col-12 mb-4">
                                                    <label for="m-edit-title" class="form-label">Title</label>
                                                    <input type="text" id="m-edit-title" name="m-edit-title" class="form-control" placeholder="Title" autocomplete="off" required />
                                                </div>
                                                <div class="col-12 col-lg-12 mb-4">
                                                    <label for="m-edit-description" class="form-label">Description</label>
                                                    <textarea name="m-edit-description" id="m-edit-description" class="form-control" cols="30" rows="5" placeholder="Description"></textarea>
                                                </div>
                                                <div class="col-12 col-lg-4 mb-4">
                                                    <label for="m-edit-status" class="form-label">Status</label>
                                                    <select id="m-edit-status" name="m-edit-status" class="form-control" required >
                                                        <option value="" selected >Select Status</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-8 mb-4">
                                                    <label class="" for="">Due Date & Repeat</label>
                                                    <div class="input-group mb-4">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <label class="switch s-primary mb-0">
                                                                    <input type="checkbox" id="m-edit-due-date-repeat" name="m-edit-due-date-repeat" onchange="change_due_date_repeat()" >
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <input type="date" id="m-edit-due-date" name="m-edit-due-date" class="form-control" placeholder="DD/MM/YYYY" value="" disabled required>
                                                        <select id="m-edit-fk-repeat-period-id" name="m-edit-fk-repeat-period-id" class="form-control" disabled required >
                                                            <option value="0" selected >No Repeat</option>
                                                            <option value="1">Daily</option>debit card cannot use
                                                            <option value="2">Weekly</option>
                                                            <option value="3">Yearly</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-4">
                                                    <div class="input-group mb-4">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <label class="switch s-primary mb-0">
                                                                    <input type="checkbox" id="m-edit-reminder" name="m-edit-reminder" onchange="change_reminder()">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Reminder</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button id="m-edit-btn-cancel" name="m-edit-btn-cancel" type="button" class="btn rounded-pill" onclick="close_edit_task_modal()" style="width: 100px; height: 40px;">Cancel</button>
                                        <button id="m-task-btn-add" name="m-task-btn-add" type="submit" class="btn btn-primary rounded-pill" form="edit-task-form" style="width: 120px; height: 40px;">Add Task</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- Edit Task Modal End -->

                        <!-- Add Task Status Modal Start -->
                        <div class="modal fade" id="addListModal" tabindex="-1" role="dialog" aria-labelledby="addListModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="compose-box">
                                            <div class="compose-content" id="addListModalTitle">
                                                <h5 class="add-list-title">Add List</h5>
                                                <h5 class="edit-list-title">Edit List</h5>
                                                <form action="javascript:void(0);">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="list-title">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                                                                <input id="s-list-name" type="text" placeholder="List Name" class="form-control" name="task">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Discard</button>
                                        <button class="btn add-list">Add List</button>
                                        <button class="btn edit-list" style="display: none;">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add Task Status Modal End -->

                        <!-- Delete Task Modal Start -->
                        <div class="modal fade back-blur-3" id="m-task-delete" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                                <div class="modal-content p-3 rounded-5">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">Confirmation</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <input type="hidden" id="m-task-id-delete" name="m-task-id-delete" value="">
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <label class="form-label">Do you want to delete this task ?</label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn rounded-pill" onclick="close_delete_task_modal( false )" style="width: 100px; height: 40px;">Cancel</button>
                                        <button type="button" class="btn btn-danger rounded-pill" style="width: 100px; height: 40px;" onclick="delete_task()">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Task Modal End -->

                        <div class="row scrumboard" id="cancel-row">
                            <div class="col-lg-12 layout-spacing">

                                <div id="task-list-section" class="task-list-section">

                                    <!-- <div data-section="s-new" class="task-list-container" data-connect="sorting">
                                        <div class="connect-sorting">
                                            <div class="task-container-header">
                                                <h6 class="s-heading" data-listTitle="In Progress">In Progress</h6>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1">
                                                        <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                                        <a class="dropdown-item list-delete" href="javascript:void(0);">Delete</a>
                                                        <a class="dropdown-item list-clear-all" href="javascript:void(0);">Clear All</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="connect-sorting-content" data-sortable="true">

                                                <div data-draggable="true" class="card img-task" style="">
                                                    <div class="card-body">

                                                        <div class="task-content">
                                                            <img src="assets/img/400x168.jpg" class="img-fluid" alt="scrumboard">
                                                        </div>

                                                        <div class="task-header">
                                                            <div class="">
                                                                <h4 class="" data-taskTitle="Creating a new Portfolio on Dribble">Creating a new Portfolio on Dribble</h4>
                                                            </div>
                                                        </div>

                                                        <div class="task-body">

                                                            <div class="task-bottom">
                                                                <div class="tb-section-1">
                                                                    <span data-taskDate="08 Aug 2020"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> 08 Aug, 2020</span>
                                                                </div>
                                                                <div class="tb-section-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 s-task-edit"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 s-task-delete"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div data-draggable="true" class="card simple-title-task" style="">
                                                    <div class="card-body">

                                                        <div class="task-header">                                                    
                                                            <div class="">
                                                                <h4 class="" data-taskTitle="Singapore Team Meet">Singapore Team Meet</h4>
                                                            </div>
                                                            <div class="">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 s-task-edit"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 s-task-delete"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                            </div>

                                            <div class="add-s-task">
                                                <a class="addTask"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Add Task</a>
                                            </div>

                                        </div>
                                    </div>

                                    <div data-section="s-in-progress" class="task-list-container" data-connect="sorting">
                                        <div class="connect-sorting">
                                            <div class="task-container-header">
                                                <h6 class="s-heading" data-listTitle="Complete">Complete</h6>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-2">
                                                        <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                                        <a class="dropdown-item list-delete" href="javascript:void(0);">Delete</a>
                                                        <a class="dropdown-item list-clear-all" href="javascript:void(0);">Clear All</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="connect-sorting-content" data-sortable="true">
                                                <div data-draggable="true" class="card simple-title-task ui-sortable-handle" style="">
                                                    <div class="card-body">

                                                        <div class="task-header">                                                    
                                                            <div class="">
                                                                <h4 class="" data-tasktitle="Dinner with Kelly Young">Dinner with Kelly Young</h4>
                                                            </div>
                                                            <div class="">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 s-task-edit"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 s-task-delete"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div data-draggable="true" class="card task-text-progress" style="">
                                                    <div class="card-body">

                                                        <div class="task-header">
                                                            
                                                            <div class="">
                                                                <h4 class="" data-taskTitle="Launch New SEO Wordpress Theme ">Launch New SEO Wordpress Theme </h4>
                                                            </div>
                                                            
                                                            <div class="">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 s-task-edit"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                            </div>

                                                        </div>

                                                        <div class="task-body">

                                                            <div class="task-content">
                                                                <p class="" data-taskText="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                                                                <div class="">
                                                                    <div class="progress br-30">
                                                                        <div class="progress-bar bg-success" role="progressbar" data-progressState="20" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>

                                                                    <p class="progress-count">20%</p>

                                                                </div>
                                                            </div>

                                                            <div class="task-bottom">
                                                                <div class="tb-section-1">
                                                                    <span data-taskDate="08 Aug 2020"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> 08 Aug, 2020</span>
                                                                </div>
                                                                <div class="tb-section-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 s-task-delete"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="add-s-task">
                                                <a class="addTask"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Add Task</a>
                                            </div>

                                        </div>
                                    </div>

                                    <div data-section="s-approved" class="task-list-container" data-connect="sorting">

                                        <div class="connect-sorting">
                                            <div class="task-container-header">
                                                <h6 class="s-heading" data-listTitle="New">New</h6>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                                                        <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                                        <a class="dropdown-item list-delete" href="javascript:void(0);">Delete</a>
                                                        <a class="dropdown-item list-clear-all" href="javascript:void(0);">Clear All</a>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="connect-sorting-content" data-sortable="true">

                                            </div>

                                            <div class="add-s-task">
                                                <a class="addTask"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Add Task</a>
                                            </div>

                                        </div>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                    </div>

                    
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

    
    <script src="<?= $config[ 'urls' ][ 'plugins' ] . "jquery-ui/jquery-ui.min.js"; ?>"></script>
    <script src="<?= $config[ 'urls' ][ 'js' ] . "ie11fix/fn.fix-padStart.js"; ?>"></script>
    <script src="<?= $config[ 'urls' ][ 'js' ] . "apps/scrumboard.js"; ?>"></script>
    

    <script>
        function read_all_task_status() {
            $( '#task-list-section' ).empty();
            const read_all_url = `${ api_url }task_status/read_all.php`;
            const fk_task_project_id = $( '#fk-task-project-id' ).val();
            const sent_data = { fk_task_project_id };
            $.ajax( {
                type    : 'POST',
                url     : read_all_url,
                data: sent_data,
                dataType: 'JSON',
                success: ( res ) => {
                    if ( res.result ) {
                        // console.log( res );
                        const data = res.data;
                        if ( data.length > 0 ) {
                            $( '#m-task-status' ).empty();
                            data.forEach( ( row_data ) => {
                                const { id, title, fk_order_id } = row_data;
                                const option = ``;
                                
                                $( '#m-task-status' ).append( $( '<option>', {
                                    value: id,
                                    text: title
                                } ) );
                                const task_status = `
                                                    <div data-section="s-${ title }" class="task-list-container" data-connect="sorting">
                                                        <div class="connect-sorting " >
                                                            <div class="task-container-header">
                                                                <h6 class="s-heading"  data-listTitle="${ title }">${ title }</h6>
                                                            </div>
                                                            <div id="t-s-c-${ id }" class="connect-sorting-content scroll-content-area" data-sortable="true" style="height: 590px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    `;
                                $( '#task-list-section' ).append( task_status );
                                read_all_task( id );
                            } );
                        }
                    }
                    $_editList();
                    $_deleteList();
                    $_clearList();
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Read All Task Status Error'
                    } );
                }
            } );
        }

        function read_all_task( fk_task_status_id ) {
            const read_all_url = `${ api_url }task/read_all.php`;
            const sent_data = { fk_task_status_id };
            $.ajax( {
                type    : 'POST',
                url     : read_all_url,
                data: sent_data,
                dataType: 'JSON',
                success: ( res ) => {
                    if ( res.result ) {
                        // console.log( res );
                        const data = res.data;
                        if ( data.length > 0 ) {
                            data.forEach( ( row_data ) => {
                                const { id, title, fk_order_id, fk_priority_id, create_at } = row_data;
                                var task_priority;
                                task_priority = fk_priority_id != 0 ? `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>` : ``;
                                task_priority = fk_priority_id == 1 ? `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon text-danger"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>` : task_priority;
                                task_priority = fk_priority_id == 2 ? `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon text-warning"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>` : task_priority;
                                task_priority = fk_priority_id == 3 ? `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon text-primary"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>` : task_priority;
                                const task = `
                                            <div data-draggable="true" class="card simple-title-task" style="" onclick="open_edit_task_modal( ${ id } )">
                                                <div class="card-body s-task-edit">
                                                    <div class="task-header">
                                                        <div class="">
                                                            <h4 class="" data-taskTitle="${ title }">${ title }</h4>
                                                        </div>
                                                        ${ task_priority }
                                                    </div>
                                                </div>
                                            </div>
                                `;
                                $( `#t-s-c-${ fk_task_status_id }` ).append( task );
                            } );
                        }
                    }
                    $_taskEdit();
                    $_taskDelete();
                    $_taskSortable();
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Read All Task Error'
                    } );
                }
            } );
        }

        function read_task( id ) {
            const read_url = `${ api_url }task/read.php`;
            const sent_data = { id };
            $.ajax( {
                type    : 'POST',
                url     : read_url,
                data: sent_data,
                dataType: 'JSON',
                success: ( res ) => {
                    if ( res.result ) {
                        console.log( res );
                        const data = res.data;
                        const { id, title, description, due_date, fk_priority_id, fk_order_id, fk_reminder_id, fk_repeat_period_id, fk_task_status_id, create_at  } = data;
                        $( '#m-task-id' ).val( id );
                        $( '#m-fk-task-order-id' ).val( fk_order_id );
                        $( '#m-task-title' ).val( title );
                        $( '#m-task-description' ).val( description );
                        $( '#m-task-status' ).val( fk_task_status_id );
                        $( '#m-fk-task-repeat-period-id' ).val( fk_repeat_period_id );
                        fk_repeat_period_id != 0 ? $( '#m-task-due-date-repeat' ).prop( 'checked', true ) : null;
                        change_due_date_repeat();
                        switch ( fk_priority_id ) {
                            case '1': 
                                $( '#m-high-priority' ).click();
                                break;
                            case '2': 
                                $( '#m-middle-priority' ).click();
                                break;
                            case '3': 
                                $( '#m-low-priority' ).click();
                                break;
                            default: 
                                $( '#m-none-priority' ).click();
                                break;
                        }
                        if ( due_date ) {
                            var dateStr = "2023-03-09 00:00:00";
                            var date = new Date(due_date);
                            var formattedDate = date.getFullYear() + "-" + ( date.getMonth() + 1 ).toString().padStart( 2, "0" ) + "-" + date.getDate().toString().padStart( 2, "0" );
                            $( '#m-task-due-date' ).val( formattedDate );
                        }
                        // create_at = new Date( create_at );
                        // create_at = create_at.toISOString().slice( 0, 10 );

                        fk_reminder_id == 1 ? $( '#m-task-reminder' ).prop( 'checked', true ) : null;
                        $( '#m-fk-task-reminder-id' ).val( fk_reminder_id );
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Read Task Error'
                    } );
                }
            } );
        }

        function open_add_task_modal() {
            reset_task_modal();
            $( '#modal-header-title' ).text( 'Add Task' );
            $( '#m-task-btn-submit' ).text( 'Add Task' );
            $( '#m-task' ).modal( 'show' );
        }

        function open_edit_task_modal( id ) {
            reset_task_modal();
            $( '#modal-header-title' ).text( 'Edit Task' );
            $( '#m-task-btn-submit' ).text( 'Edit Task' );
            read_task( id );
            $( '#m-task' ).modal( 'show' );
        }

        function open_delete_task_modal() {
            $( '#m-task' ).modal( 'hide' );
            const id = $( '#m-task-id' ).val();
            $( '#m-task-id-delete' ).val( id );
            $( '#m-task-delete' ).modal( 'show' );
        }

        function close_task_modal() {
            // Reset
            $( '#m-task' ).modal( 'hide' );
            reset_task_modal();
        }

        function close_delete_task_modal( delete_status ) {
            if ( delete_status ) {
                close_task_modal();
                $( '#m-task-delete' ).modal( 'hide' );
            } else {
                $( '#m-task' ).modal( 'show' );
                $( '#m-task-delete' ).modal( 'hide' );
            }   
        }


        function reset_task_modal() {
            document.getElementById( 'task-form' ).reset();
            $( '#m-task-id' ).val( 0 );
            $( '#m-fk-task-order-id' ).val( 0 );
            $( '#m-fk-task-reminder-id' ).val( 0 );
            $( '#m-task-due-date' ).prop( 'disabled', true );
            $( '#m-fk-task-repeat-period-id' ).prop( 'disabled', true );
            $( '#m-none-priority' ).click();
        }

        function change_due_date_repeat() {
            const checked = $( '#m-task-due-date-repeat' ).prop( 'checked' );
            const due_date = $( '#m-task-due-date' );
            const repeat = $( '#m-fk-task-repeat-period-id' );
            due_date.prop( 'disabled', ! checked );
            ! checked ? due_date.val( '' ) : null;
            repeat.prop( 'disabled', ! checked );
            ! checked ? repeat.val( '0' ) : null;
        }

        function change_priority( value ) {
            $( '#m-fk-task-priority-id' ).val( value );
        }

        function change_reminder() {
            const checked = $( '#m-task-reminder' ).prop( 'checked' );
            const reminder = $( '#m-fk-task-reminder-id' );
            reminder.val( checked ? 1 : 0 );
        }

        function priority_dropdown() {
            $('.priority-dropdown .dropdown-menu .dropdown-item').on('click', function(event) {
                var getClass = $(this).attr('class').split(' ')[1];
                var getDropdownClass = $(this).parents('.p-dropdown').children('.dropdown-toggle').attr('class').split(' ')[1];
                $(this).parents('.p-dropdown').children('.dropdown-toggle').removeClass(getDropdownClass);
                $(this).parents('.p-dropdown').children('.dropdown-toggle').addClass(getClass);
            })
        }

        function add_task() {
            const create_url          = `${ api_url }task/create.php`;
            const title               = $( '#m-task-title' ).val();
            const description         = $( '#m-task-description' ).val();
            const fk_task_status_id   = $( '#m-task-status' ).val();
            const fk_priority_id      = $( '#m-fk-task-priority-id' ).val();
            const fk_reminder_id      = $( '#m-fk-task-reminder-id' ).val();
            const fk_order_id         = 1;
            const fk_repeat_period_id = $( '#m-fk-task-repeat-period-id' ).val();
            let sent_date = {};
            const checked = $( '#m-task-due-date-repeat' ).prop( 'checked' );
            if ( checked ) {
                const due_date = $( '#m-task-due-date' ).val();
                sent_data = { title, description, fk_task_status_id, fk_order_id, fk_priority_id, fk_reminder_id, due_date, fk_repeat_period_id };
            } else {
                sent_data = { title, description, fk_task_status_id, fk_order_id, fk_priority_id, fk_reminder_id, fk_repeat_period_id };
            }
            // console.log( sent_data );
            $.ajax( {
                type    : 'POST',
                url     : create_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    console.log(res);
                    if ( res.result ) {
                        close_task_modal();
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

        function edit_task() {
            const update_url          = `${ api_url }task/update.php`;
            const id               = $( '#m-task-id' ).val();
            const title               = $( '#m-task-title' ).val();
            const description         = $( '#m-task-description' ).val();
            const fk_task_status_id   = $( '#m-task-status' ).val();
            const fk_priority_id      = $( '#m-fk-task-priority-id' ).val();
            const fk_reminder_id      = $( '#m-fk-task-reminder-id' ).val();
            const fk_order_id         = $( '#m-fk-task-order-id' ).val();
            const fk_repeat_period_id = $( '#m-fk-task-repeat-period-id' ).val();
            let sent_date = {};
            const checked = $( '#m-task-due-date-repeat' ).prop( 'checked' );
            if ( checked ) {
                const due_date = $( '#m-task-due-date' ).val();
                sent_data = { id, title, description, fk_task_status_id, fk_order_id, fk_priority_id, fk_reminder_id, due_date, fk_repeat_period_id };
            } else {
                sent_data = { id, title, description, fk_task_status_id, fk_order_id, fk_priority_id, fk_reminder_id, fk_repeat_period_id };
            }
            // console.log( sent_data );
            $.ajax( {
                type    : 'POST',
                url     : update_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    // console.log(res);
                    if ( res.result ) {
                        close_task_modal();
                        refresh();
                        Toast.fire( {
                            icon : 'success',
                            title: 'Update Task Success'
                        } );
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Update Task Error'
                    } );
                }
            } );
        }

        function delete_task() {
            const id = $( '#m-task-id-delete' ).val();
            const delete_url = `${ api_url }task/delete.php`;
            const sent_data = { id };
            $.ajax( {
                type    : 'POST',
                url     : delete_url,
                dataType: 'JSON',
                data    : sent_data,
                success: ( res ) => {
                    // console.log(res);
                    if ( res.result ) {
                        close_delete_task_modal( true );
                        refresh();
                        Toast.fire( {
                            icon : 'success',
                            title: 'Delete Task Success'
                        } );
                    }
                    return res;
                },
                error: ( err ) => {
                    Toast.fire( {
                        icon : 'error',
                        title: 'Delete Task Error'
                    } );
                }
            } );
        }


        $( '#task-form' ).submit( ( event ) => {
            event.preventDefault();
            if ( $( '#m-task-id' ).val() == 0 ) {
                add_task();
            } else {
                edit_task();
            }
            
        } );

        function refresh() {
            read_all_task_status();
            priority_dropdown();
            addTask();
        }

        refresh();
    </script>

</body>
</html>