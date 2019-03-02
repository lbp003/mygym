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
    $contact_id=$_REQUEST['contact_id'];
    
    $objcon = new contact();
    $resultCon=$objcon->displayConMessage($contact_id);
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
                        <li><a href="#" class="active">Send Reply</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Send Reply</b></h1>
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
                    <form method="post" name="SendReply" action="../controller/contactController.php?status=Reply&contact_id=<?php echo $contact_id?>&staff_id=<?php echo $userDetails['staff_id']?>" enctype="multipart/form-data">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8"> 
                            <div class="form-group">
                                <label for="from">To</label>                         
                                <input name="fname" type="text" class="form-control" id="fname" readonly value="<?php echo $reCon['fname']?>">
                                <input name="lname" type="text" class="form-control" id="lname" readonly value="<?php echo $reCon['lname']?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" type="text" class="form-control" id="email" readonly value="<?php echo $reCon['email']?>">
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input name="subject" type="text" class="form-control" id="subject" readonly value="<?php echo $reCon['subject']?>">
                            </div>
                             <div class="form-group">
                                <label for="message">Message</label>
                                <textarea type="text" id="reply" class="form-control" name="reply"  rows="15"></textarea>
                            </div>
                            </div>
                        <div class="col-md-2">&nbsp;</div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="notification.php" class="btn btn-lg btn-info" name="back" value="Inbox" style="float: right">Inbox</a>
                                </div>
                                <div class="col-md-4">&nbsp;</div>
                                <div class="col-md-4">
                                    <a class="btn btn-lg btn-info" name="reply" type="submit" value="Reply" style="float:left">Reply</a> 
                                </div>
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
            
            var reply = $('#reply').val();
            
           if(reply==""){
           $('#error_msg').text("Reply can't be empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#reply').focus();
           return false;
           }
        });
    });
</script>