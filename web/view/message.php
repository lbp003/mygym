<!--header start ---->
<?php include '../common/myPlanHeader.php'; ?>
<?php include '../admin/model/contactModel.php'; ?><!-- including tracking model ----->
<?php
$userDetails=$_SESSION['userDetails'];
$role_id=$userDetails['role_id'];
// Get All contact messages
$objcon= new contact();
//$AllContactMsg = $objcon->displayAllConMsg();
//$AllContactReply = $objcon->displayAllConReply();

//echo print_r($AllContactReply);

?>
<script type="text/javascript">
            function deleteRow(){
                var r=confirm("Do you want to DELETE the message ?");
                if(!r){
                    return false;
                    
                }
                
            }
    </script>
    <script type="text/javascript">
        $(function () {
        $('[data-toggle="tooltip"]').tooltip()
            })
    </script>
<!----header end -----> 
<body onload="startTime()">
        <!---navbar starting ---------->
        <?php include '../common/myPlanNav.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="myPlan.php" >Dashboard </a></li>
                        <li><a href="#" class="active" >Message</a></li>
                    </ol>
                </div>
        </div>
        <!--- breadcrumb ending--------->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <!---- side nav starting------>
            <?php include '../common/myPlanSideNav.php'; ?>
            <!---- side nav ending------>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    <div>
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Messages</b></h1><b />
                    </div><br />
                    <div>
                    <?php if(isset($_REQUEST['msg'])){ 
                        $msg= base64_decode($_REQUEST['msg']);
                    ?>
                    <span class="alert alert-success"><?php echo $msg; ?></span>
                                
                    <?php   } ?>
                    </div>
                </div>
            </div><hr />
            <div class="row">
                <div class="col-md-12">
<!-------Staff Message Starting----------------->
            <div class="row">
                <div class="col-md-12"><br />
                    <a href="SendMSMessage.php" style="float:right; background-color: #3399ff; color: white" class="btn" data-toggle="tooltip" data-placement="left" title="Send new message to a staff">Send New Message</a><br />
                  <h2 align="center" style="color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Staff Inbox</b></h2>    
                </div>
            </div><br />
            <div class="row">
                <table id="" class=" display table table-striped table-responsive" style="width: 100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">From</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Date & Time</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>                    
                        <?php
                        $AllUserMsgSIn = $objcon->displayAllUserMsgSInbox();
                        if(!$AllUserMsgSIn){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $memberIn_id=$userDetails['member_id'];                       
                        $count=0;
                        while($StInRow = $AllUserMsgSIn->fetch_assoc()) {
                            $type=$StInRow['type'];
                            $inbox=$StInRow['to_user'];
                            if($memberIn_id == $inbox && $type == 'SM'){                           
                            $status=$StInRow['status'];
                            $count++; 
                            ?>
                                <tr <?php                      
                                    if($status=="Delete"){?> 
                                        style="display: none" 
                                    <?php 
                                    }elseif ($status=="Unread") { ?> 
                                        style="font-weight: bold;color: #333333"

                                <?php } ?>>
                                <td>
                                      <?php echo ucfirst($StInRow['staff_fname'])." ". ucfirst($StInRow['staff_lname'])?>
                                </td>
                                <td><?php echo $StInRow['subject'];?></td>
                                <td><?php echo $StInRow['time'];?></td>
                                <td>
                                    <a href="../admin/controller/contactController.php?message_id=<?php echo $StInRow['user_message_id']?>&status=ViewMsgIn&type=<?php echo $StInRow['type']?>&fname=<?php echo $StInRow['staff_fname']?>&lname=<?php echo $StInRow['staff_lname']?>&wh=M" class="btn btn-default"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../admin/controller/contactController.php?message_id=<?php echo $StInRow['user_message_id']?>&status=DeleteMsg&wh=M" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    <button class="btn btn-warning"><?php if($status=="Read"){?><i class="fa fa-envelope-open" data-toggle="tooltip" data-placement="top" title="Read"></i><?php }else{?><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="Unread"></i><?php } ?></button>
                                </td>
                              </tr>
                        <?php }
                        } ?>
                    </tbody>
                  </table><hr />
            </div>
            <div class="row">
                <div class="col-md-12">
                  <h2 align="center" style="color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Staff Outbox</b></h2>  
                </div>
            </div><br />
            <div class="row">
                 <table id="" class=" display table table-striped table-responsive" style="width: 100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">TO</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Date & Time</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>                    
                        <?php
                        $AllUserMsgSOut=$objcon->displayAllUserMsgSOutbox();
                        if(!$AllUserMsgSOut){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $memberOut_id=$userDetails['member_id'];
                        $count=0;
                        while($StOutRow = $AllUserMsgSOut->fetch_assoc()) {
                            $type=$StOutRow['type'];
                            $outbox=$StOutRow['from_user'];
                            if($memberOut_id == $outbox && $type == 'MS'){                           
                            $status=$StOutRow['status'];
                            $count++;
                            ?>
                                <tr <?php 
                                if($status=="Delete"){?> 
                                    style="display: none"  
                                <?php } ?>>
                                <td>
                                      <?php echo ucfirst($StOutRow['staff_fname'])." ". ucfirst($StOutRow['staff_lname'])?>
                                </td>
                                <td><?php echo $StOutRow['subject'];?></td>
                                <td><?php echo $StOutRow['time'];?></td>
                                <td>
                                    <a href="../admin/controller/contactController.php?status=ViewMsgOut&message_id=<?php echo $StOutRow['user_message_id']?>&fname=<?php echo $StOutRow['staff_fname']?>&lname=<?php echo $StOutRow['staff_lname']?>&wh=M" class="btn" style="background-color: #66cc00"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../admin/controller/contactController.php?message_id=<?php echo $StOutRow['user_message_id']?>&status=DeleteMsg&wh=M" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    <button  class="btn" style="background-color: #66cc00"><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="Sent"></i></i></button>
                                </td>
                              </tr>
                            <?php } 
                        }?>
                    </tbody>
                  </table><hr /> 
            </div>
        <!----------Staff Message Ending----------------->
                                <!----------Member Message Starting----------------->
            <div class="row">
                <div class="col-md-12"><br />
                    <a href="SendMMMessage.php" style="float:right; background-color: #3399ff; color: white" class="btn" data-toggle="tooltip" data-placement="left" title="Send new message to a member">Send New Message</a><br />
                  <h2 align="center" style="color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Member Inbox</b></h2>    
                </div>
            </div><br />
            <div class="row">
                <table id="" class=" display table table-striped table-responsive" style="width: 100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">From</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Date & Time</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>                    
                        <?php
                        $AllUserMsgMIn = $objcon->displayAllUserMsgMInbox();
                        if(!$AllUserMsgMIn){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $memberIn_id=$userDetails['member_id'];                       
                        $count=0;
                        while($MeInRow = $AllUserMsgMIn->fetch_assoc()) {
                            $type=$MeInRow['type'];
                            $inbox=$MeInRow['to_user'];
                            if($memberIn_id == $inbox && $type == 'MM'){                           
                            $status=$MeInRow['status'];
                            $count++; 
                            ?>
                                <tr <?php                      
                                    if($status=="Delete"){?> 
                                        style="display: none" 
                                    <?php 
                                    }elseif ($status=="Unread") { ?> 
                                        style="font-weight: bold;color: #333333"

                                <?php } ?>>
                                <td>
                                      <?php echo ucfirst($MeInRow['member_fname'])." ". ucfirst($MeInRow['member_lname'])?>
                                </td>
                                <td><?php echo $MeInRow['subject'];?></td>
                                <td><?php echo $MeInRow['time'];?></td>
                                <td>
                                    <a href="../admin/controller/contactController.php?message_id=<?php echo $MeInRow['user_message_id']?>&status=ViewMsgIn&type=<?php echo $MeInRow['type']?>&fname=<?php echo $MeInRow['member_fname']?>&lname=<?php echo $MeInRow['member_lname']?>&wh=M" class="btn" style="background-color: #66cc00"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../admin/controller/contactController.php?message_id=<?php echo $MeInRow['user_message_id']?>&status=DeleteMsg&wh=M" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    <button class="btn"><?php if($status=="Read"){?><i class="fa fa-envelope-open" data-toggle="tooltip" data-placement="top" title="Read"></i><?php }else{?><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="Unread"></i><?php } ?></button>
                                </td>
                              </tr>
                        <?php }
                        } ?>
                    </tbody>
                  </table><hr />
            </div>
            <div class="row">
                <div class="col-md-12">
                  <h2 align="center" style="color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Member Outbox</b></h2>  
                </div>
            </div><br />
            <div class="row">
                 <table id="" class=" display table table-striped table-responsive" style="width: 100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">TO</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Date & Time</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>                    
                        <?php
                        $AllUserMsgMOut=$objcon->displayAllUserMsgMOutbox();
                        if(!$AllUserMsgMOut){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $memberOut_id=$userDetails['member_id'];
                        $count=0;
                        while($MeOutRow = $AllUserMsgMOut->fetch_assoc()) {
                            $type=$MeOutRow['type'];
                            $outbox=$MeOutRow['from_user'];
                            if($memberOut_id == $outbox && $type == 'MM'){                           
                            $status=$MeOutRow['status'];
                            $count++;
                            ?>
                                <tr <?php 
                                if($status=="Delete"){?> 
                                    style="display: none"  
                                <?php } ?>>
                                <td>
                                      <?php echo ucfirst($MeOutRow['member_fname'])." ". ucfirst($MeOutRow['member_lname'])?>
                                </td>
                                <td><?php echo $MeOutRow['subject'];?></td>
                                <td><?php echo $MeOutRow['time'];?></td>
                                <td>
                                    <a href="../admin/controller/contactController.php?status=ViewMsgOut&message_id=<?php echo $MeOutRow['user_message_id']?>&fname=<?php echo $MeOutRow['member_fname']?>&lname=<?php echo $MeOutRow['member_lname']?>&wh=M" class="btn" style="background-color: #66cc00"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../admin/controller/contactController.php?message_id=<?php echo $MeOutRow['user_message_id']?>&status=DeleteMsg&wh=M" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    <button  class="btn" style="background-color: #66cc00"><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="Sent"></i></i></button>
                                </td>
                              </tr>
                            <?php } 
                        }?>
                    </tbody>
                  </table><hr /> 
            </div>
            <!----------Member Message Ending----------------->
                    </div>
                </div>
            </div>  
    </div>
</div>
<!---- Footer start---->
<?php include '../common/myPlanFooter.php'; ?>
<!---- Footer end------>
        <script>
            $(document).ready(function() {
            $('table.display').DataTable();
                } );
        </script>