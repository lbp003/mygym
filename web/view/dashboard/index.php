<!--- header start ---->
<?php include_once '../../layout/default_header.php'; ?>
<?php 
    if(empty($user['image'])){
        $path = "../../../".PATH_IMAGE."user.png"; 
    }else{ 
        $path = "../../../".PATH_IMAGE.PATH_MEMBER_IMAGE.$user['image'];                    
    } 
?>
<!--- header end ----> 
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/default_navBar.php';?> 
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
        <div class="col-12">
            <div class="d-flex justify-content-end">
            <div class="col-4">
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 15rem;">
                        <i class="far fa-calendar-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/classSessionController.php"><h5 class="card-title">CLASS SESSION</h5></a>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="col-4">
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 15rem;">
                        <i class="far fa-calendar-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/classSessionController.php"><h5 class="card-title">CLASS SESSION</h5></a>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="col-4">
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 15rem;">
                        <i class="far fa-calendar-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/classSessionController.php"><h5 class="card-title">CLASS SESSION</h5></a>
                        </div>
                        </div>
                    </div>
            </div>
            </div><hr />
        </div>
            <div class="col-4">
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 15rem;">
                        <i class="far fa-calendar-alt fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/classSessionController.php"><h5 class="card-title">CLASS SESSION</h5></a>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="col-4">

                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                <i class="fas fa-dumbbell fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/equipmentController.php"><h5 class="card-title">EQUIPMENT</h5></a>
                        </div>
                        </div>
                    </div>
   
            </div>
            <div class="col-4">
     
                    <div class="mb-3">
                        <div class="card align-items-center border-dark" style="width: 100%;">
                        <i class="fas fa-running fa-5x dash-icon-color"></i>
                        <div class="card-body">
                            <a href="../../../controller/exerciseController.php"><h5 class="card-title">EXERCISE</h5></a>
                        </div>
                        </div>
                    </div>
      
            </div>
        </div>
    </div>
    <?php include_once '../../layout/default_footer.php';?>