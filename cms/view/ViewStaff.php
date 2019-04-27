<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ---->
<?php include '../model/staffModel.php'; ?> <!-- including staff model ----->
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $obm = new CommonFun();
    $resultm=$obm->viewRoleModule($role_id);
    //echo $userDetails['gender'].$userDetails['dob'];
    //print_r($resultm);
?>
<?php 
    $objRo = new CommonFun();
    $resultRo=$objRo->viewRole();
    $_SESSION['resultRo']=$resultRo;
    //print_r($resultRo);

    $staff_id = $_REQUEST['staff_id'];
    $obstUp = new staff();
    $result = $obstUp->displayStaff($staff_id);
    if(!$result){
        die("ERROR".mysqli_error($con));
    }
    $resultUpSt =$result->fetch_assoc();
    
    // Create an array for staff record
   // $abc=$result->fetch_assoc();
    //if(!$abc){
   //     die("Query FAILED".mysqli_error($con));
    //} else {
//echo $abc[staff_fname];        
//}
?>
<body onload="startTime()">
        <!---navbar starting ---------->
        <?php include '../common/navBar.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="Dashboard.php" >Dashboard</a></li>
                        <li><a href="staff.php" >Staff</a></li>
                        <li><a href="#" class="active">View Staff</a></li>
                    </ol>
                </div>
        </div>
        <!--- breadcrumb ending--------->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                <!----Admin side nav starting------>
            <?php include '../common/AdminSideNav.php'; ?>
                <!----Admin side nav ending------>
                </div>
                <div class="col-md-9" style="background-color:rgb(250,250,250); ">
                    <div>
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Profile</b></h1>
                    </div><hr />
                    <form method="post" name="UpdateStaff" action="../controller/staffcontroller.php?status=View&staff_id=<?php echo $staff_id;?>" enctype="multipart/form-data">
                        <div class="col-md-3">
                             <div>
                                 <?php 
                                   if($resultUpSt['staff_image']==""){
                                       $path="../images/user.png";
                                   }else{
                                       $path="../images/staff_image/".$resultUpSt['staff_image'];
                                   }
                                 ?>
                                <img src="<?php echo $path; ?>" width="150px" height="auto" class="img-responsive img-circle center-block"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                           
                           <div class="form-group">
                                <label for="funame">Full Name</label>
                                <input type="text" name="funame" class="form-control readonlyt" id="funame"  value="<?php echo ucfirst($resultUpSt['staff_fname'])." ". ucfirst($resultUpSt['staff_lname']);?>" readonly="">
                             </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control readonlyt" id="email" value="<?php echo $resultUpSt['staff_email'];?>" readonly="">
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" name="dob" class="form-control readonlyt" id="dob" value="<?php echo $resultUpSt['dob'];?>" disabled="">
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label><br/>
                                <input type="radio" class="radio radio-inline readonlyt" id="male" name="gender" value="Male" <?php if(strtolower($resultUpSt['gender'])=="male") echo "Checked"?> disabled=""> &nbsp;&nbsp;Male
                                <input type="radio" class="radio radio-inline readonlyt" id="female" name="gender" value="Female" <?php if(strtolower($resultUpSt['gender'])=="female") echo "Checked"?> disabled=""> &nbsp;&nbsp;Female
                            </div>                             
                             <div class="form-group">
                                <label for="tel">Telephone</label>
                                <input name="tel" type="text" class="form-control readonlyt" id="tel" value="<?php echo $resultUpSt['staff_tel'];?>" readonly="">
                            </div>
                             <div class="form-group">
                                <label for="address">Address</label>
                                <textarea type="text" class="form-control readonlyt" id="address" name="address" rows="4" readonly=""><?php echo $resultUpSt['address'];?></textarea>
                            </div>
                             <div class="form-group">
                                <label for="nic">NIC</label>
                                <input type="text" class="form-control readonlyt" id="nic" name="nic" value="<?php echo $resultUpSt['nic'];?>" readonly="">
                            </div>
                             <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" name="role"  disabled="">
                                   <option>Select Role</option>
                                    <?php while ($rowRole=$resultRo->fetch_assoc()){ ?>
                                    <option value="<?php $rowRole['role_id'];?>" 
                                        <?php    if($rowRole['role_id']==$resultUpSt['role_id']) echo "SELECTED"; ?>>
                                                 <?php echo ucfirst($rowRole['role_name']);?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            </div>
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-12">
                           <div class="row">
                                <div class="col-md-4">&nbsp;</div>
                                <div class="col-md-4">
                                    <a href="staff.php" class="btn btn-lg btn-info btn-block" name="back">Okay</a>
                                </div>
                                <div class="col-md-4">&nbsp;</div>
                            </div> 
                        </div>
                    </form>
                </div>
        </div>
        </div>
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>