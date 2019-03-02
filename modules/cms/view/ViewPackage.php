<!--- header start ---->
<?php include '../common/adHeader.php';?>
<!--- header end ---->
<?php include '../model/packageModel.php';?>
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $obm = new CommonFun();
    $resultm=$obm->viewRoleModule($role_id);
    //echo $userDetails['gender'].$userDetails['dob'];
    //print_r($resultm);
    $package_id=$_REQUEST['package_id'];
    
    $objpa = new package();
    $resultpa = $objpa->displayPackage($package_id);
    $rePa=$resultpa->fetch_assoc();
    //echo $rePa['package_name'];
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
                        <li><a href="#" class="active">View Package</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>View Package</b></h1>
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
                    <form method="post" name="UpdatePackage" action="../controller/packageController.php?status=Update&package_id=<?php echo $package_id;?>" enctype="multipart/form-data">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                            <div class="row">
                                 <?php 
                                   if($rePa['package_image']==""){
                                       $path="../images/user.png";
                                   }else{
                                       $path="../images/package_image/".$rePa['package_image'];
                                   }
                                 ?>
                                <img src="<?php echo $path; ?>" width="350px" height="auto" class="img-responsive img-thumbnail center-block"/>
                            </div><br />
                             <div class="form-group">
                                <label for="package_name">Package Name</label>
                                <input name="package_name" type="text" class="form-control" id="pname" value="<?php echo $rePa['package_name'];?>" readonly>
                            </div>
                             <div class="form-group">
                                <label for="package_description">Package Description</label>
                                <textarea type="text" class="form-control" id="pdes" name="package_description"  rows="15" disabled><?php echo $rePa['package_description'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="package_price">Package Ammount</label>
                                <input type="text" class="form-control" id="pam" name="package_ammount" value="<?php echo $rePa['price'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration in Months</label>
                                <input type="text" class="form-control" id="duration" name="duration" value="<?php echo $rePa['duration'];?>" readonly>
                            </div>
                            </div>
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-4"><br /><br />
                                <a class="btn btn-lg btn-info btn-block" href="Package.php" name="submit" type="submit" value="Submit"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
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
<!--<script type="text/javascript">
    
    $(document).ready(function(){
        $('form').submit(function(){
            
            var name = $('#pname').val();
            var des = $('#pdes').val();
            var ammount = $('#pam').val();
            var duration = $('#duration').val();
            var image = $('#img').val();
            
           if(name==""){
           $('#error_msg').text("Package Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#pname').focus();
           return false;
           }
           if(des==""){
           $('#error_msg').text("Package Description is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#pdes').focus();
           return false; //
           }
           if(ammount==""){
           $('#error_msg').text("Ammount is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#pam').focus();
           return false; //
           }
           if(duration==""){
           $('#error_msg').text("Ammount is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#duration').focus();
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

</script>-->