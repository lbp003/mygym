<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ---->
<?php include '../model/myWorkoutModel.php'; ?><!-- including member model ----->
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
    $resultRo=$objRo->viewAnatomy();
//    $_SESSION['resultRo']=$resultRo;
//    print_r($resultRo);
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
                        <li><a href="myWorkout.php" >myWorkout</a></li>
                        <li><a href="#" class="active">Add Exercise</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Add Exercise</b></h1>
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
                    <form method="post" name="AddmyWorkout" action="../controller/myWorkoutcontroller.php?status=Add" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exercise_name">exercise name</label>
                                <input type="text" name="ename" class="form-control" id="ename" placeholder="Exercise Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="anatomy">Body Part</label>
                                <select id="anatomy_id" name="anatomy" class="form-control">
                                    <option>Select Body Part</option>
                                    <?php 
                                    while($anatomy=$resultRo->fetch_assoc()){                                    
                                    echo "<option value=".$anatomy['anatomy_id'].">". ucfirst($anatomy['anatomy_name'])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"><br /><br />
                                <button class="btn btn-lg btn-danger btn-block" name="reset" type="reset" value="Reset">Reset</button>
                                <button class="btn btn-lg btn-info btn-block" name="submit" type="submit" value="Submit">Submit</button>
                            </div>
                            <div class="col-md-4"></div>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>
<script type="text/javascript">
    $(document).ready(function(){
       $('form').submit(function(){
              
       var ename=$('#ename').val();
       var anatomy_id=$('#anatomy_id').val();
 
      if(ename==""){
           $('#error_msg').text("Exercise Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#ename').focus();
           return false; //
       }
       if(anatomy_id==""){
           $('#error_msg').text("Anatomy Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#anatomy_id').focus();
           return false; //
       }   
   });
   });

</script>