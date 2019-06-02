<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ---->
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $obm = new CommonFun();
    $resultm=$obm->viewRoleModule($role_id);
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
                        <li><a href="#" class="active">Add Package</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Add Package</b></h1>
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
                    <form method="post" name="AddPackage" action="../controller/packageController.php?status=Add" enctype="multipart/form-data">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="package_name">Package Name</label>
                                <input name="package_name" type="text" class="form-control" id="pname" placeholder="Family">
                            </div>
                             <div class="form-group">
                                <label for="package_description">Package Description</label>
                                <textarea type="text" class="form-control" id="pdes" name="package_description"  rows="15" ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="package_ammount">Package Ammount</label>
                                <input type="text" class="form-control" id="pam" name="package_ammount"  >
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration in Months</label>
                                <input type="text" class="form-control" id="duration" name="duration" >
                            </div>
                             <div class="form-group">
                                <label for="package_image">Package Image</label>
                                <input type="file" id="img" name="package_image" class="form-control" onchange="readURL(this)"><br/>
                                <img id="img_prev" class="center-block" />
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
            .height(70);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

</script>