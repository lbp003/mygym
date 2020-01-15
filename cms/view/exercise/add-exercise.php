<!--- header  ---->
<?php
include '../../layout/header.php'; ?>
<?php 
    $anatomyData = $_SESSION['anatomyData'];
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Add Exercise</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="addExercise" name="addExercise" action="../../../controller/exerciseController.php?status=Insert" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="exercise_name">Exercise Name</label>
                        <input type="text" class="form-control" id="exercise_name" name="exercise_name" aria-describedby="exercise_name" placeholder="Exercise Name" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="anatomy">Anatomy</label>
                        <select id="anatomy" name="anatomy" class="form-control">
                            <option value="" selected>Choose...</option>
                            <?php foreach($anatomyData as $key => $val){?>
                                <option value="<?php echo $key?>"><?php echo $val?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mb-2 float-right">Submit</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>

<script type="text/javascript">
    $(document).ready(function(){

        // Form validation
        $('#addExercise').validate({
            rules: {
                exercise_name: "required",
                anatomy: "required"
            },
            messages: {
                exercise_name: {
                    required: "Please enter exercise name"
                },
                anatomy: {
                    required: "Please select anatomy"
                }
            }
        });
    });
</script>