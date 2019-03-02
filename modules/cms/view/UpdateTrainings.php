<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ---->
<?php include '../model/trainingModel.php';?>
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $obm = new CommonFun();
    $resultm=$obm->viewRoleModule($role_id);
    //echo $userDetails['gender'].$userDetails['dob'];
    //print_r($resultm);
    $resultt=$obm->viewTrainers();
?>
<?php 

$training_id=$_REQUEST['training_id'];

   $objtr = new trainings();
   $resulttr=$objtr->displayTraining($training_id);
   $reTr = $resulttr->fetch_assoc();
   //echo $reTr['training_name'];
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
                        <li><a href="trainings.php" >Trainings</a></li>
                        <li><a href="#" class="active">Update Training</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Update Training</b></h1>
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
                    <form method="post" name="UpdateTraining" action="../controller/trainingsController.php?status=Update&training_id=<?php echo $training_id?>" enctype="multipart/form-data">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="training_name">Training Name</label>
                                <input name="training_name" type="text" class="form-control" id="tname" placeholder="CrossFit" value="<?php echo $reTr['training_name']?>">
                            </div>
                             <div class="form-group">
                                <label for="training_description">Training Description</label>
                                <textarea type="text" class="form-control" id="tdes" name="training_description"  rows="15"><?php echo $reTr['training_description']?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="role">Instructor</label>
                                <select class="form-control" name="instructor_id" id="staff_id">
                                    <option disabled="">Select Instructor</option>
                                    <?php while($rowIns=$resultt->fetch_assoc()){ ?>
                                        <option value="<?php echo $rowIns['staff_id'];?>" 
                                        <?php    if($rowIns['staff_id']==$reTr['instructor_id']) echo "SELECTED"; ?>>
                                                 <?php echo ucfirst($rowIns['staff_fname'])." ". ucfirst($rowIns['staff_lname']) ;?>
                                        </option>
                                    <?php 
                                    
                                    }
                                    ?>
                                    
                                </select>
                            </div>
                             <div class="form-group">
                                <label for="training_image">Training Image</label>
                                <input type="file" id="img" name="training_image" class="form-control" onchange="readURL(this)"><br/>
                                <?php 
                                    if($reTr['training_image']==""){
                                        $path="../images/user.png";
                                    }else{
                                        $path="../images/training_image/".$reTr['training_image'];
                                    }
                                ?>
                                <img id="img_prev" class="center-block" src="<?php echo $path;?>" width="100px"/>
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
            
            var name = $('#tname').val();
            var des = $('#tdes').val();
            var staff_id = $('#staff_id').val();
            var image = $('#img').val();
            
           if(name==""){
           $('#error_msg').text("Training Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#tname').focus();
           return false;
           }
           if(des==""){
           $('#error_msg').text("Training Description is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#tdes').focus();
           return false; //
           }
           if(staff_id==""){
           $('#error_msg').text("Trainer is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#staff_id').focus();
           return false; //
           }
           if(image!=""){
           var arr=image.split(".");
           var last=arr.length-1;
           var iext=arr[last].toLowerCase();
           var extarr=['jpg','jpeg','gif','png','tiff','svg'];
           if($.inArray(iext,extarr)==-1){
           $('#error_msg').text("Invalid extension");
           $('#error_msg').addClass('alert-danger');
           $('#img').focus();
           return false; //  
           
       }   
       }
       
               });
    });
    
       function readURL(input) {
        if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_prev')
            .attr('src', e.target.result)
            .height(100);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>