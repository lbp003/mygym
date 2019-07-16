<!--- header  ---->
<?php include '../../layout/header.php'; ?>
<?php 
    $empData = $_SESSION['empData'];
    // var_dump($empData); exit;

    $gender = ['M' => 'Male', 'F' => 'Female'];
    $type = ['A' => 'Admin', 'M' => 'Manager', 'T' => 'Trainer'];
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Staff</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Update Staff</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="addStaff" name="addStaff" action="../../../controller/staffController.php?status=Update" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" aria-describedby="first_name" placeholder="First Name" value="<?php echo $empData['first_name']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" aria-describedby="last_name" placeholder="Last Name" value="<?php echo $empData['last_name']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Email" value="<?php echo $empData['email']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control">
                            <?php foreach($gender as $key => $val){ ?>
                                <option value="<?php echo $key?>" <?php echo ($key == $empData['gender']) ? "selected" : NULL ?>><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" aria-describedby="dob" placeholder="Date of Birth" value="<?php echo $empData['dob']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="nic">NIC</label>
                        <input type="text" class="form-control" id="nic" name="nic" aria-describedby="nic" placeholder="NIC" value="<?php echo $empData['nic']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phone" placeholder="Phone" value="<?php echo $empData['telephone']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="user_type">Type</label>
                        <select id="user_type" name="user_type" class="form-control">
                            <?php foreach($type as $key => $val){?>
                                <option value="<?php echo $key?>" <?php echo ($key == $empData['staff_type']) ? "selected" : NULL ?>><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo $empData['address']?></textarea>
                    </div>
                    <!-- <div class="form-group col-6">
                        <label for="pro_pic">Profile Picture</label>
                        <input type="file" class="form-control" id="pro_pic" name="pro_pic" rows="3" />
                    </div> -->
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
                    remote: {
                        url: '../../../controller/staffController.php?status=checkEmail',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            email: function(){
                                return $("#email").val();
                            }
                        }
                    }
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
                user_type: "required",
                address: "required",
                pro_pic: {
                required: false,
                extension: "JPEG|JPG"
                }


            },
            messages: {
                first_name: {
                    required: "Please enter your first name"
                },
                last_name: {
                    required: "Please enter your last name"
                },
                email: {
                    required: "Please enter your email address",
                    remote: function() { return $.validator.format("{0} is already taken", $("#email").val()) }
                },
                dob: {
                    required: "Please enter your birth date"
                },
                gender: {
                    required: "Please enter your gender"
                },
                nic: {
                    required: "Please enter your NIC"
                },
                phone: {
                    required: "Please enter your phone",
                    minlength: "Invalid phone number"
                },
                user_type: {
                    required: "Please enter user type"
                },
                address: {
                    required: "Please enter your address"
                },
            }
        });
    });
</script>