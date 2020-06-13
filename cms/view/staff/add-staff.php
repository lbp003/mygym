<?php include '../../layout/header.php'; ?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Staff</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Add Staff</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="addStaff" name="addStaff" action="../../../controller/staffController.php?status=Add" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" aria-describedby="first_name" placeholder="First Name">
                    </div>
                    <div class="form-group col-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" aria-describedby="last_name" placeholder="Last Name">
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Email">
                    </div>
                    <div class="form-group col-6">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="" selected>Choose...</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="dob">Date of Birth</label>
                        <input type="text" class="form-control" id="dob" name="dob" aria-describedby="dob">
                    </div>
                    <div class="form-group col-6">
                        <label for="joined_date">Joined Date</label>
                        <input type="text" class="form-control" id="joined_date" name="joined_date" aria-describedby="joined_date">
                    </div>
                    <div class="form-group col-6">
                        <label for="nic">NIC</label>
                        <input type="text" class="form-control" id="nic" name="nic" aria-describedby="nic" placeholder="NIC">
                    </div>
                    <div class="form-group col-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phone" placeholder="Phone">
                    </div>
                    <div class="form-group col-6">
                        <label for="user_type">Type</label>
                        <select id="user_type" name="user_type" class="form-control">
                            <option value="" selected>Choose...</option>
                            <option value="A">Admin</option>
                            <option value="M">Manager</option>
                            <option value="T">Trainer</option>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
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
        $('#addStaff').validate({
            rules: {
                first_name: "required",
                last_name: "required", 
                email: {
					required: true,
					email: true,
                    remote: "../../../controller/staffController.php?status=checkEmail"
				},
                dob: {
                    required: true,
                    date: true
                },
                joined_date: {
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
                user_type: "required",
                address: "required",
                pro_pic: {
                required: false,
                extension: "JPEG|JPG"
                }


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
                    remote: "Email address is already taken"
                },
                dob: {
                    required: "Please enter birth date"
                },
                joined_date: {
                    required: "Please enter joined date"
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
                user_type: {
                    required: "Please enter user type"
                },
                address: {
                    required: "Please enter address"
                },
            }
        });

        $( "#dob" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
        });

        $( "#joined_date" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
        });
    });
</script>