<!--- header  ---->
<?php
include '../../layout/header.php'; ?>
<?php 
    $trainersData = $_SESSION['trainersData'];
    $classData = $_SESSION['classData'];
    $sessionData = $_SESSION['sessionData'];
    // echo var_dump($classData); exit;

    $daysAr = ['Mon' => 'Monday',
                'Tue' => 'Tuesday',
                'Wed' => 'Wednesday',
                'Thu' => 'Thursday',
                'Fri' => 'Friday',
                'Sat' => 'Saturday',
                'Sun' => 'Sunday'
            ];

?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Class Session</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Update Class Session</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="addClassSession" name="addClassSession" action="../../../controller/classSessionController.php?status=Update" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="session_name">Session Name</label>
                        <input type="text" class="form-control is-valid" id="session_name" name="session_name" aria-describedby="session_name" placeholder="Session Name" required value="<?php echo $sessionData['class_session_name']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="class">Class</label>
                        <select id="class" name="class" class="form-control">
                            <option selected>Choose...</option>
                            <?php foreach($classData as $key => $val){?>
                                <option value="<?php echo $key?>" <?php echo ($key == $sessionData['class_id']) ? "selected" : NULL ?>><?php echo $val?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="day">Day</label>
                        <select id="day" name="day" class="form-control">
                            <?php foreach($daysAr as $key => $val){ ?>
                            <option value="<?php echo $key;?>" <?php echo ($key == $sessionData['day']) ? "selected" : NULL ?>><?php echo $val;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="start_time">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" aria-describedby="start_time" value="<?php echo $sessionData['start_time']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="end_time">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" aria-describedby="end_time" placeholder="end_time" value="<?php echo $sessionData['end_time']?>"> 
                    </div>
                    <div class="form-group col-6">
                        <label for="Instructor">Instructor</label>
                        <select id="instructor" name="instructor" class="form-control">
                            <option>Choose...</option>
                            <?php foreach($trainersData as $key => $val){?>
                            <option value="<?php echo $key;?>" <?php echo ($key == $sessionData['instructor_id']) ? "selected" : NULL ?>><?php echo $val;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="hidden" name="class_session_id" value="<?php echo $sessionData['class_session_id']?>"> 
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
        $('#addClassSession').validate({
            rules: {
                class_name: "required",
                day: "required", 
                // session_name: {
				// 	required: true,
				// 	session_name: true,
                //     remote: {
                //         url: '../../../controller/classSessionController.php?status=checkUpdateSessionName',
                //         type: 'post',
                //         data: {
                //             session_name: function(){
                //                 return $("#session_name").val();
                //             }
                //         }
                //     }
				// },
                start_time: {
                    required: true
                },
                end_time: {
                    required: function(element) {
                        return $("#start_time").val() < $("#end_time").val();
                    }
                },
                instructor: "required"
            },
            messages: {
                class_name: {
                    required: "Please enter class name"
                },
                last_name: {
                    required: "Please enter last name"
                },
                session_name: {
                    required: "Please enter session name",
                    remote: function() { return $.validator.format("{0} is already taken", $("#session_name").val()) }
                },
                instructor: {
                    required: "Please select a instructor"
                }
            }
        });
    });
</script>