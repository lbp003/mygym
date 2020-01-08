<!--- header start ---->
<?php include_once '../../layout/header.php'; ?>
<!--- header end ----> 
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Report</a></li>
    </ol>
    </nav>
    <!-- module container -->
    <div class="container">
        <div class="row">
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_STAFF])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center" style="width: 100%;">
                        <i class="fas fa-briefcase fa-5x dash-icon-color"></i>
                        <div class="card-body">
                        <a href="../../../controller/reportController.php?status=Employee"><h6 class="card-title">STAFF REPORT</h6></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_CLASS, Role::VIEW_CLASS])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center" style="width: 100%;">
                        <i class="fas fa-skating fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php?status=Class"><h6 class="card-title">CLASS REPORT</h6></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_EQUIPMENT, Role::VIEW_EQUIPMENT])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center" style="width: 100%;">
                        <i class="fas fa-dumbbell fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php?status=Equipment"><h6 class="card-title">EQUIPMENT REPORT</h6></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_WORKOUT, Role::VIEW_WORKOUT])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center" style="width: 100%;">
                        <i class="fas fa-running fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php?status=Exercise"><h6 class="card-title">EXERCISE REPORT</h6></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_EVENT, Role::VIEW_EVENT])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center" style="width: 100%;">
                        <i class="fas fa-futbol fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php?status=Event"><h6 class="card-title">EVENT REPORT</h6></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_PACKAGE, Role::VIEW_PACKAGE])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center" style="width: 100%;">
                        <i class="fas fa-gift fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php?status=Package"><h6 class="card-title">PACKAGE REPORT</h6></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_STAFF, Role::VIEW_STAFF])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center" style="width: 100%;">
                        <i class="fas fa-users fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php?status=Member"><h6 class="card-title">MEMBER REPORT</h6></a>
                        </div>
                        </div>
                    </div> 
                <?php } ?>
            </div>  
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_SUBSCRIPTION, Role::VIEW_SUBSCRIPTION])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center" style="width: 100%;">
                        <i class="fas fa-money-check-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php?status=Subscription"><h6 class="card-title">SUBSCRIPTION REPORT</h6></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>  
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_SUBSCRIPTION, Role::VIEW_SUBSCRIPTION])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center" style="width: 100%;">
                        <i class="fas fa-money-check-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php?status=Subscription"><h6 class="card-title">PAYMENT REPORT</h6></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>  
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_CLASS_SESSION, Role::VIEW_CLASS_SESSION])){ ?>
                    <div class="mb-3 mr-4">
                        <div class="card align-items-center" style="width: 15rem;">
                        <i class="far fa-calendar-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php?status=classSession"><h6 class="card-title">CLASS SESSION REPORT</h6></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>     
        </div>
    </div>
    <?php include_once '../../layout/footer.php';?>