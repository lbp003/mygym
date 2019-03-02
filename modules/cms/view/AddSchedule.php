<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/trainingModel.php';?>
<!--- header end ---->
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $objT = new trainings();    
    $reT = $objT->displayAllTrainings();
//    $obm = new CommonFun();
//    $resultm=$obm->viewRoleModule($role_id);
    //echo $userDetails['gender'].$userDetails['dob'];
    //print_r($resultm);
    
?>
<?php 
//    $objRo = new CommonFun();
//    $resultRo=$objRo->viewRole();
//    $_SESSION['resultRo']=$resultRo;
//    //print_r($resultRo);
//?>
<body onload="startTime()">
        <!---navbar starting ---------->
        <?php include '../common/navBar.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="Dashboard.php" >Dashboard</a></li>
                        <li><a href="package.php" >Package</a></li>
                        <li><a href="#" class="active">Time slot</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Add Time Slot</b></h1>
                    </div><hr />
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <?php if(isset($_REQUEST['msg'])){ 
                                $msg= base64_decode($_REQUEST['msg']);
                            ?>
                            <span class="alert alert-danger"><?php echo $msg; ?></span>
                                
                            <?php   } ?>
                            
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div id="error_msg" style="text-align: center" >&nbsp;</div>
                            <div>&nbsp;</div>
                        </div>
                        </div>
                    </div><br />
                    <form method="post" name="AddTimeSlot" action="../controller/scheduleController.php?status=Add" enctype="multipart/form-data">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="training">Training program</label>
                                <select class="form-control" id="training" name="training">
                                    <option disabled selected>Select a Training</option>
                                  <?php while($rowT=$reT->fetch_assoc()){ ?>
                                  <option value="<?php echo $rowT['training_id'];?>"><?php echo $rowT['training_name'];?></option>
                                  <?php } ?>
                                </select>
                            </div>
                             <div class="form-group">
                                <label for="day">Day</label>
                                <select class="form-control" id="day" name="day">
                                  <option disabled selected>Select a day</option>
                                  <option value="Monday">Monday</option>
                                  <option value="Tuesday">Tuesday</option>
                                  <option value="Wednesday">Wednesday</option>
                                  <option value="Thursday">Thursday</option>
                                  <option value="Friday">Friday</option>
                                  <option value="Saturday">Saturday</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="start_time">Start Time</label>
                                <input type="time" class="form-control" id="stime" name="stime">
                            </div>
                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <input type="time" class="form-control" id="etime" name="etime">
                            </div>
                            <div class="form-group">
                                <label for="color">Background Color</label>
                                <input type="color" class="form-control" value="#577f92" id="color" name="color">
                            </div>
                        </div>
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-4"><br /><br />
                                <button class="btn btn-lg btn-danger btn-block" name="reset" type="reset" value="Reset">Reset</button>
                                <button class="btn btn-lg btn-info btn-block" name="submit" type="submit" value="Submit">Submit</button>
                            </div>
                            <div class="col-md-4">&nbsp;</div>
                        </div>
                        </div>                       
                    </form>
                </div>
        </div>
        </div><br />
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('form').submit(function(){
            
            var training = $('#training').val();
            var day = $('#day').val();
            var stime = $('#stime').val();
            var etime = $('#etime').val();
            var color = $('#color').val();
            
           if(training==""){
           $('#error_msg').text("Training program is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#training').focus();
           return false;
           }
           if(day==""){
           $('#error_msg').text("Day is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#day').focus();
           return false; //
           }
           if(stime==""){
           $('#error_msg').text("Start time is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#stime').focus();
           return false; //
           }
           if(etime==""){
           $('#error_msg').text("End time is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#etime').focus();
           return false; //
           }
           if(color==""){
           $('#error_msg').text("End time is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#etime').focus();
           return false; //
           }
               });
    });
</script>