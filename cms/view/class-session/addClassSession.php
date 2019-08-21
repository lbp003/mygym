<!--- header  ---->
<?php
include '../../layout/header.php'; ?>
<?php 
    $trainersData = $_SESSION['trainersData'];
    $classData = $_SESSION['classData'];
    // echo var_dump($classData); exit;

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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Add Class Session</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="addClassSession" name="addClassSession" action="../../../controller/classSessionController.php?status=Insert" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="session_name">Session Name</label>
                        <input type="text" class="form-control is-valid" id="session_name" name="session_name" aria-describedby="session_name" placeholder="Session Name" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="class_name">Class</label>
                        <select id="class_name" name="class_name" class="form-control">
                            <option selected>Choose...</option>
                            <?php foreach($classData as $key => $val){?>
                                <option value="<?php echo $key?>"><?php echo $val?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="day">Day</label>
                        <select id="day" name="day" class="form-control">
                            <option selected>Choose...</option>
                            <option value="Mon">Monday</option>
                            <option value="Tue">Tuesday</option>
                            <option value="Wed">Wednesday</option>
                            <option value="Thu">Thursday </option>
                            <option value="Fri">Friday</option>
                            <option value="Sat">Saturday</option>
                            <option value="Sun">Sunday</option>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="start_time">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" aria-describedby="start_time">
                    </div>
                    <div class="form-group col-6">
                        <label for="end_time">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" aria-describedby="end_time" placeholder="end_time">
                    </div>
                    <div class="form-group col-6">
                        <label for="Instructor">Instructor</label>
                        <select id="instructor" name="instructor" class="form-control">
                            <option selected>Choose...</option>
                            <?php foreach($trainersData as $key => $val){?>
                            <option value="<?php echo $key;?>"><?php echo $val;?></option>
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
        $('#addClassSession').validate({
            rules: {
                class_name: "required",
                day: "required", 
                session_name: {
					required: true,
					email: true,
                    // remote: {
                    //     url: '../../../controller/memberController.php?status=checkEmail',
                    //     type: 'post',
                    //     dataType: 'json',
                    //     data: {
                    //         email: function(){
                    //             return $("#email").val();
                    //         }
                    //     }
                    // }
				},
                dob: {
                    required: true,
                    date: true
                },
                gender: "required",
                nic: "required",
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10
                },
                package: "required",
                address: "required",
                membership_number: "required"
            },
            messages: {
                first_name: {
                    required: "Please enter first name"
                },
                last_name: {
                    required: "Please enter last name"
                },
                email: {
                    required: "Please enter email address",
                    remote: function() { return $.validator.format("{0} is already taken", $("#email").val()) }
                },
                dob: {
                    required: "Please enter birth date"
                },
                gender: {
                    required: "Please enter gender"
                },
                nic: {
                    required: "Please enter NIC"
                },
                phone: {
                    required: "Please enter phone",
                    minlength: "Invalid phone number"
                },
                package: {
                    required: "Please select a package"
                },
                address: {
                    required: "Please enter address"
                },
                membership_number:{
                    required: "Please enter membership number"
                }
            }
        });
    });
</script>