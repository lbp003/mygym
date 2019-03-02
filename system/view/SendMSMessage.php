<!--- header start ---->
<?php include_once '../common/myPlanHeader.php'; ?>
<!--- header end ---->
<?php include '../admin/model/contactModel.php';?>
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    
//    $obm = new CommonFun();
//    $resultm=$obm->viewRoleModule($role_id);
//    //echo $userDetails['gender'].$userDetails['dob'];
//    //print_r($resultm);
//    $resultt=$obm->viewTrainers();
?>
<body onload="startTime()">
        <!---navbar starting ---------->
        <?php include '../common/myPlanNav.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="Dashboard.php" >Dashboard</a></li>
                        <li><a href="message.php" >Message </a></li>
                        <li><a href="#" class="active">Send Message</a></li>
                    </ol>
                </div>
        </div>
        <!--- breadcrumb ending--------->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                <!----Admin side nav starting------>
            <?php include '../common/myPlanSideNav.php'; ?>
                <!----Admin side nav ending------>
                </div>
                <div class="col-md-9" style="background-color:rgb(250,250,250); ">
                    <div>
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Send Message</b></h1>
                    </div><hr />
                    <div class="row">
                        <div class="col-md-12" id="msg" style="text-align: center">
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
                    <form method="post" name="SendMsg" action="../admin/controller/contactController.php?status=SendMSmsg" enctype="multipart/form-data">
                        <div class="col-md-2">&nbsp;</div>
                        <div class="col-md-8">
                            <div class="form-group">
                                 <label for="from" style="display: none">From</label>
                                <input name="fromMember" type="hidden" class="form-control" id="from" readonly value="<?php echo $userDetails['member_id']?>">
                            </div>
                            <div class="form-group">
                                <label for="To">To</label>
                                <input type="text" class="form-control typeahead" data-provide="typeahead" id="toStaff" name="toStaff" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input name="subject" type="text" class="form-control" id="subject">
                            </div>
                             <div class="form-group">
                                <label for="message">Message</label>
                                <textarea type="text" class="form-control" id="message" name="message"  rows="15"></textarea>
                            </div>
                            </div>
                        <div class="col-md-2">&nbsp;</div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4"><br />&nbsp;                
                                </div>
                            <div class="col-md-4"><br />
                                <button class="btn btn-lg btn-danger btn-block" name="reset" type="reset" value="Reset">Reset</button>
                                <button class="btn btn-lg btn-info btn-block" name="submit" type="submit" value="Submit">Send</button>
                            </div>
                                <div class="col-md-4"><br />&nbsp;
                                </div>
                        </div>
                        </div>                       
                    </form>
                </div>
        </div>
        </div><br />
<!---- Footer start---->
<?php include '../common/myPlanFooter.php'; ?>
<!---- Footer end------>
<script type="text/javascript">
    $(document).ready(function(){
        $("#msg").delay(5000).fadeOut("slow");
        $('#toStaff').typeahead({
         minLength: 2,
         //highlight: true
         source: function(query, result)
         {
          $.ajax({
           url:"getStaffFront.php",
           method:"POST",
           data:{query:query},
           dataType:"json",
           success:function(data)
           {
            result($.map(data, function(item){
             return item;
            }));
           }
          })
         }
        });

        $('form').submit(function(){
            
            var to = $('#toStaff').val();
            var subject = $('#subject').val();
            var message = $('#message').val();

           if(to==""){
           $('#error_msg').text("Receiver can not be empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#toStaff').focus();
           return false;
           } 
           if(subject==""){
           $('#error_msg').text("Subject can not be empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#subject').focus();
           return false;
           } 
           if(message==""){
           $('#error_msg').text("Message can not be empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#message').focus();
           return false;
           }
        });
        
    });
</script>