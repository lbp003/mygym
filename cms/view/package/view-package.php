<?php
include '../../layout/header.php'; ?>
<?php
    $packData = $_SESSION['packData'];

    if(empty($packData['image'])){
        $path = "../../../".PATH_IMAGE."user.png"; 
    }else{ 
        $path = "../../../".PATH_IMAGE.PATH_PACKAGE_IMAGE.$packData['image'];                    
    } 
?> 
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Package</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">View Package</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6" style="text-align:center">
                        <img src="<?php echo $path; ?>" width="120" height="auto" class="img-responsive img-thumbnail" />
                    </div>
                    <div class="form-group col-6">
                        <label for="package_name">Package Name</label>
                        <input type="text" class="form-control" id="package_name" name="package_name" aria-describedby="package_name" value="<?php echo $packData['package_name'];?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="fee">Fee (LKR)</label>
                        <input type="text" class="form-control" id="fee" name="fee" aria-describedby="fee" value="<?php echo $packData['fee'];?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="duration">Duration (Months)</label>
                        <input type="number" class="form-control" id="duration" name="duration" aria-describedby="duration" value="<?php echo $packData['duration'];?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" readonly><?php echo $packData['package_description'];?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>