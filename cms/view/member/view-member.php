<!--- header  ---->
<?php include '../../layout/header.php'; ?>
<?php 
    $memData = $_SESSION['memData'];
    // var_dump($memData); exit;
    $pacData = $_SESSION['pacData'];

    $gender = ['M' => 'Male', 'F' => 'Female'];

    if(empty($memData['image'])){
        $path = "../../../".PATH_IMAGE."user.png"; 
    }else{ 
        $path = "../../../".PATH_IMAGE.PATH_MEMBER_IMAGE.$memData['image'];                    
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
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Member</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">View Member</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
                <form>
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6" style="text-align:center">
                        <img src="<?php echo $path; ?>" width="120" height="auto" class="img-responsive img-thumbnail" />
                    </div>
                    <div class="form-group col-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" aria-describedby="first_name" placeholder="First Name" value="<?php echo $memData['first_name']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" aria-describedby="last_name" placeholder="Last Name" value="<?php echo $memData['last_name']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Email" value="<?php echo $memData['email']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control" readonly>
                            <?php foreach($gender as $key => $val){ ?>
                                <option value="<?php echo $key?>" <?php echo ($key == $memData['gender']) ? "selected" : NULL ?>><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" aria-describedby="dob" placeholder="Date of Birth" value="<?php echo $memData['dob']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="nic">NIC</label>
                        <input type="text" class="form-control" id="nic" name="nic" aria-describedby="nic" placeholder="NIC" value="<?php echo $memData['nic']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phone" placeholder="Phone" value="<?php echo $memData['telephone']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" readonly><?php echo $memData['address']?></textarea>
                    </div>
                    <div class="form-group col-6">
                        <label for="package">Package</label>
                        <select id="package" name="package" class="form-control" readonly>
                            <option selected>Choose...</option>
                            <?php foreach($pacData as $key => $val){?>
                            <option value="<?php echo $key;?>" <?php echo ($key == $memData['package_id']) ? "selected" : NULL ?>><?php echo $val;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="membership_number">Membership Number</label>
                        <input type="text" class="form-control" id="membership_number" name="membership_number" aria-describedby="membership_number" placeholder="Membership Number"  value="<?php echo $memData['membership_number']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="joined_date">Joined Date</label>
                        <input type="text" class="form-control" id="joined_date" name="joined_date" aria-describedby="joined_date" autocomplete="off" value="<?php echo $memData['joined_date']?>" readonly>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>