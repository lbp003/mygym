<?php include '../../layout/header.php'; ?>
<?php 
    $equData = $_SESSION['equData'];
    // var_dump($equData); exit;

    if(empty($equData['image'])){
        $path = "../../../".PATH_IMAGE."user.png"; 
    }else{ 
        $path = "../../../".PATH_IMAGE.PATH_EQUIPMENT_IMAGE.$equData['image'];                    
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
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Equipment</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">View Equipment</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <div class="form-group col-6" style="text-align:center">
                        <img src="<?php echo $path; ?>" width="120" height="auto" class="img-responsive img-thumbnail" />
                    </div>
                    <div class="form-group col-6">
                        <label for="class_name">Equipment Name</label>
                        <input type="text" class="form-control" id="class_name" name="class_name" aria-describedby="class_name" placeholder="Class Name" value="<?php echo $equData['equipment_name']?>" readonly> 
                        <br />
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" readonly><?php echo $equData['equipment_description']?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>