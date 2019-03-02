<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ---->
<?php include '../model/contactModel.php';?>
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
//    $obm = new CommonFun();
//    $resultm=$obm->viewRoleModule($role_id);
//    //echo $userDetails['gender'].$userDetails['dob'];
//    //print_r($resultm);
//    $resultt=$obm->viewTrainers();
?>
<?php 

$reply_id=$_REQUEST['reply_id'];

   $objcon = new contact();
   $resultCon=$objcon->displayReply($reply_id);
   $reCon = $resultCon->fetch_assoc();
   //echo $reTr['training_name'];
?>
<script type="text/javascript">
            function deleteRow(){
                var r=confirm("Do you want to DELETE the message ?");
                if(!r){
                    return false;
                    
                }
                
            }
    </script>
<body onload="startTime()">
        <!---navbar starting ---------->
        <?php include '../common/navBar.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="Dashboard.php" >Dashboard</a></li>
                        <li><a href="notification.php" >Notification</a></li>
                        <li><a href="#" class="active">View Reply</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>View Reply</b></h1>
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
                    </div>
                    <form method="post" name="viewMsg" action="#" enctype="multipart/form-data">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="from">To</label>
                                <input name="from" type="text" class="form-control" id="fname" readonly value="<?php echo $reCon['fname']?>">
                                <input name="from" type="text" class="form-control" id="lname" readonly value="<?php echo $reCon['lname']?>">
                            </div>
                            <div class="form-group">
                                <label for="from">From</label>
                                <input name="from" type="text" class="form-control" id="fname" readonly value="<?php echo $reCon['staff_fname']?>">
                                <input name="from" type="text" class="form-control" id="lname" readonly value="<?php echo $reCon['staff_lname']?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="date">Date & Time</label>
                                <input name="date" type="datetime" class="form-control" id="date" readonly value="<?php echo $reCon['time_out']?>">
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input name="subject" type="text" class="form-control" id="subject" readonly value="<?php echo"Re: ".$reCon['subject']?>">
                            </div>
                             <div class="form-group">
                                <label for="message">Message</label>
                                <textarea type="text" class="form-control" id="msg" name="reply"  rows="15" readonly><?php echo $reCon['reply']?></textarea>
                            </div>
                            </div>
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-4">
                                <a href="../controller/contactController.php?reply_id=<?php echo $reply_id;?>&status=DeleteReply" class="btn btn-lg btn-danger center-block" name="delete" type="submit" onclick="return deleteRow()">Delete</a><br />
                                <a href="notification.php" class="btn btn-lg btn-info center-block" name="back" type="submit" >Inbox</a>
                            </div>
                                <div class="col-md-4"><br />&nbsp;</div>
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
    
//    $(document).ready(function(){
//        $('form').submit(function(){
//            
//            var name = $('#tname').val();
//            var des = $('#tdes').val();
//            var inst = $('#staff_id').val();
//            var image = $('#img').val();
//            
//           if(name==""){
//           $('#error_msg').text("Training Name is empty");//To display error
//           $('#error_msg').addClass('alert-danger');
//           $('#tname').focus();
//           return false;
//           }
//           if(des==""){
//           $('#error_msg').text("Training Description is empty");//To display error
//           $('#error_msg').addClass('alert-danger');
//           $('#tdes').focus();
//           return false; //
//           }
//           if(ins==""){
//           $('#error_msg').text("Training Instructor is empty");//To display error
//           $('#error_msg').addClass('alert-danger');
//           $('#staff_id').focus();
//           return false; //
//           }
//           if(image==""){
//           $('#error_msg').text("Training Image is empty");//To display error
//           $('#error_msg').addClass('alert-danger');
//           $('#img').focus();
//           return false; //
//           }
//           if(image!=""){
//           var arr=image.split(".");
//           var last=arr.length-1;
//           var iext=arr[last].toLowerCase();
//           var extarr=['jpg','jpeg','gif','png','tiff','svg'];
//           if($.inArray(iext,extarr)==-1){
//           $('#error_msg').text("Invalid extension");
//           $('#error_msg').addClass('alert-danger');
//           $('#img').focus();
//           return false; //  
//           
//       }   
//       }
//       function readURL(input) {
//        if (input.files && input.files[0]) {
//        var reader = new FileReader();
//
//        reader.onload = function (e) {
//            $('#img_prev')
//            .attr('src', e.target.result)
//            .height(70);
//        };
//
//        reader.readAsDataURL(input.files[0]);
//    }
//}
//        })
//    })
</script>