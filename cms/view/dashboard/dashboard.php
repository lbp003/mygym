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
        <li class="breadcrumb-item active" aria-current="page">Home</li>
    </ol>
    </nav>
    <!-- module container -->
    <div class="container">
        <div class="row">
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_MEMBER, Role::VIEW_MEMBER])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-users fa-5x dash-icon-color"></i>
                        <div class="card-body">
                        <a href="../../../controller/memberController.php"><h5 class="card-title">MEMBER</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_CLASS, Role::VIEW_CLASS])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-skating fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/classController.php"><h5 class="card-title">CLASS</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_CLASS_SESSION, Role::VIEW_CLASS_SESSION])){ ?>
                    <div class="mb-3 mr-4">
                        <div class="card align-items-center border-dark" style="width: 15rem;">
                        <i class="far fa-calendar-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/classSessionController.php"><h5 class="card-title">CLASS SESSION</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_EQUIPMENT, Role::VIEW_EQUIPMENT])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                <i class="fas fa-dumbbell fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/equipmentController.php"><h5 class="card-title">EQUIPMENT</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_WORKOUT, Role::VIEW_WORKOUT])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-running fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/exerciseController.php"><h5 class="card-title">EXERCISE</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_EVENT, Role::VIEW_EVENT])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-futbol fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/eventController.php"><h5 class="card-title">EVENT</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_PAYMENT, Role::VIEW_PAYMENT])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fab fa-cc-paypal fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="#"><h5 class="card-title">ONLINE PAYMENT</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_PACKAGE, Role::VIEW_PACKAGE])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-gift fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/packageController.php"><h5 class="card-title">PACKAGE</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_SUBSCRIPTION, Role::VIEW_SUBSCRIPTION])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-money-check-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/subscriptionController.php"><h5 class="card-title">SUBSCRIPTION</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_REPORT, Role::VIEW_REPORT])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-chart-line fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/reportController.php"><h5 class="card-title">REPORT</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_MESSAGE, Role::VIEW_MESSAGE])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-comment-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/contactController.php"><h5 class="card-title">MESSAGE</h5></a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_STAFF, Role::VIEW_STAFF])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-briefcase fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/staffController.php"><h5 class="card-title">STAFF</h5></a>
                        </div>
                        </div>
                    </div> 
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::VIEW_MEMBER_LOGIN_LOG, Role::VIEW_STAFF_LOGIN_LOG])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-map-marker fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/logController.php"><h5 class="card-title">LOG</h5></a>
                        </div>
                        </div>
                    </div>          
                <?php } ?>
            </div>
            <div class="col-3">
                <?php if($auth->checkPermissions([Role::MANAGE_BACKUP])){ ?>
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="far fa-save fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/backupController.php"><h5 class="card-title">BACKUP</h5></a>
                        </div>
                        </div>
                    </div>          
                <?php } ?>
            </div>
        </div>
    </div>
    <?php include_once '../../layout/footer.php';?>