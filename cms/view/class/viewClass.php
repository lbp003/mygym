<!--- header  ---->
<?php include '../../layout/header.php'; ?>
<?php 
    $clsData = $_SESSION['clsData'];
    // var_dump($clsData); exit;

    if(empty($clsData['image'])){
        $path = "../../../".PATH_IMAGE."user.png"; 
    }else{ 
        $path = "../../../".PATH_IMAGE.PATH_CLASS_IMAGE.$clsData['image'];                    
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
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Class</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">View Class</a></li>
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
                        <label for="class_name">Class Name</label>
                        <input type="text" class="form-control" id="class_name" name="class_name" aria-describedby="class_name" placeholder="Class Name" value="<?php echo $clsData['class_name']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="color">Color</label>
                        <input type="text" class="form-control" id="color" name="color" aria-describedby="color" placeholder="color" value="<?php echo $clsData['color']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" readonly><?php echo $clsData['class_description']?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>