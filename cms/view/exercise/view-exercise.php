<?php
include '../../layout/header.php'; ?>
<?php 
    $anatomyData = $_SESSION['anatomyData'];
    $excData = $_SESSION['excData'];
    // echo var_dump($anatomyData); exit;

?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Exercise</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">View Exercise</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="exercise_name">Exercise Name</label>
                        <input type="text" class="form-control" id="exercise_name" name="exercise_name" aria-describedby="exercise_name" value="<?php echo $excData['exercise_name']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="class">Anatomy</label>
                        <select id="class" name="class" class="form-control" readonly>
                            <option selected>Choose...</option>
                            <?php foreach($anatomyData as $key => $val){?>
                                <option value="<?php echo $key?>" <?php echo ($key == $excData['anatomy_id']) ? "selected" : NULL ?>><?php echo $val?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>