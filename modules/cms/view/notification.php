<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/contactModel.php'; ?><!-- including tracking model ----->
<?php
$userDetails=$_SESSION['userDetails'];
$role_id=$userDetails['role_id'];
// Get All contact messages
$objcon= new contact();
$AllContactMsg = $objcon->displayAllConMsg();
$AllContactReply = $objcon->displayAllConReply();
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
        <?php include '../common/navBar.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="Dashboard.php" >Dashboard</a></li>
                        <li><a href="#" class="active" >Notifications</a></li>
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
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    <div>
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Messages</b></h1><b />
                    </div>
                    <div><br />
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
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">Contact Messages</a></li>
                            <li role="presentation"><a href="#staff" aria-controls="staff" role="tab" data-toggle="tab">Staff Messages</a></li>
                            <li role="presentation"><a href="#member" aria-controls="member" role="tab" data-toggle="tab">Member Messages</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="contact">
                                    <!----------Contact Message Starting----------------->
            <div class="row">
                <div class="col-md-12">
                  <h2 align="center" style="color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Contact Inbox</b></h2>  
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
                        if(!$AllContactMsg){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $count=0;
                        while($ConRow = $AllContactMsg->fetch_assoc()) {
                            $count++; 
                            
                            $status=$ConRow['status'];
                            ?>
                                <tr <?php 
                                if($status=="Delete"){?> 
                                    style="display: none" 
                                    <?php 
                                }elseif ($status=="Unread") { ?> 
                                    style="font-weight: bold;color: #333333"

                                <?php } ?>>
                                <td>
                                      <?php echo ucfirst($ConRow['fname'])." ". ucfirst($ConRow['lname'])?>
                                </td>
                                <td><?php echo $ConRow['subject'];?></td>
                                <td><?php echo $ConRow['time'];?></td>
                                <td>
                                    <a href="../controller/contactController.php?contact_id=<?php echo $ConRow['contact_id']?>&status=View" class="btn" style="background-color: #66cc00"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../controller/contactController.php?contact_id=<?php echo $ConRow['contact_id']?>&status=Delete" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    <button class="btn"><?php if($status=="Read"){?><i class="fa fa-envelope-open" data-toggle="tooltip" data-placement="top" title="Read"></i><?php }else{?><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="Unread"></i><?php } ?></button>
                                </td>
                              </tr>
                            <?php } ?>
                    </tbody>
                  </table><hr />
            </div>
            <div class="row">
                <div class="col-md-12">
                  <h2 align="center" style="color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Contact Outbox</b></h2>  
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
                        if(!$AllContactReply){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $count=0;
                        while($RepRow = $AllContactReply->fetch_assoc()) {
                            $count++;
                            
                            $status=$RepRow['status_reply'];
                            ?>
                                <tr <?php 
                                if($status=="DeleteReply"){?> 
                                    style="display: none"  
                                <?php } ?>>
                                <td>
                                      <?php echo ucfirst($RepRow['fname'])." ". ucfirst($RepRow['lname'])?>
                                </td>
                                <td><?php echo $RepRow['subject'];?></td>
                                <td><?php echo $RepRow['time_out'];?></td>
                                <td>
                                    <a href="../controller/contactController.php?reply_id=<?php echo $RepRow['reply_id']?>&status=ViewReply" class="btn" style="background-color: #66cc00"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../controller/contactController.php?reply_id=<?php echo $RepRow['reply_id']?>&status=DeleteReply" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    <button  class="btn" style="background-color: #66cc00"><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="Sent"></i></i></button>
                                </td>
                              </tr>
                            <?php } ?>
                    </tbody>
                  </table><hr /> 
            </div>
            <!----------Contact Message Ending----------------->
                            </div>
                            <div role="tabpanel" class="tab-pane" id="staff">
                                <!----------Staff Message Starting----------------->
            <div class="row">
                <div class="col-md-12"><br />
                    <a href="SendSSMessage.php" style="float:right; background-color: #3399ff; color: white" class="btn" data-toggle="tooltip" data-placement="left" title="Send new message to a staff">Send New Message</a><br />
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
                        $staffIn_id=$userDetails['staff_id'];                       
                        $count=0;
                        while($StInRow = $AllUserMsgSIn->fetch_assoc()) {
                            $type=$StInRow['type'];
                            $inbox=$StInRow['to_user'];
                            if($staffIn_id == $inbox && $type == 'SS'){                           
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
                                    <a href="../controller/contactController.php?message_id=<?php echo $StInRow['user_message_id']?>&status=ViewMsgIn&type=<?php echo $StInRow['type']?>&fname=<?php echo $StInRow['staff_fname']?>&lname=<?php echo $StInRow['staff_lname']?>" class="btn" style="background-color: #66cc00"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../controller/contactController.php?message_id=<?php echo $StInRow['user_message_id']?>&status=DeleteMsg" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
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
                        $staffOut_id=$userDetails['staff_id'];
                        $count=0;
                        while($StOutRow = $AllUserMsgSOut->fetch_assoc()) {
                            $type=$StOutRow['type'];
                            $outbox=$StOutRow['from_user'];
                            if($staffOut_id == $outbox && $type == 'SS'){                           
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
                                    <a href="../controller/contactController.php?status=ViewMsgOut&message_id=<?php echo $StOutRow['user_message_id']?>&fname=<?php echo $StOutRow['staff_fname']?>&lname=<?php echo $StOutRow['staff_lname']?>" class="btn" style="background-color: #66cc00"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../controller/contactController.php?message_id=<?php echo $StOutRow['user_message_id']?>&status=DeleteMsg" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    <button  class="btn" style="background-color: #66cc00"><i class="fa fa-paper-plane" data-toggle="tooltip" data-placement="top" title="Sent"></i></i></button>
                                </td>
                              </tr>
                            <?php } 
                        }?>
                    </tbody>
                  </table><hr /> 
            </div>
        <!----------Staff Message Ending----------------->
                            </div>
                            <div role="tabpanel" class="tab-pane" id="member">
                                <!----------Member Message Starting----------------->
            <div class="row">
                <div class="col-md-12"><br />
                  <a href="SendSMMessage.php" style="float:right; background-color: #3399ff; color: white" class="btn" data-toggle="tooltip" data-placement="left" title="Send new message to a member">Send New Message</a><br />
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
                        $staffIn_id=$userDetails['staff_id'];                       
                        $count=0;
                        while($MeInRow = $AllUserMsgMIn->fetch_assoc()) {
                            $type=$MeInRow['type'];
                            $inbox=$MeInRow['to_user'];
                            if($staffIn_id == $inbox && $type == 'MS'){                           
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
                                    <a href="../controller/contactController.php?message_id=<?php echo $MeInRow['user_message_id']?>&status=ViewMsgIn&type=<?php echo $MeInRow['type']?>&fname=<?php echo $MeInRow['member_fname']?>&lname=<?php echo $MeInRow['member_lname']?>" class="btn" style="background-color: #66cc00"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../controller/contactController.php?message_id=<?php echo $MeInRow['user_message_id']?>&status=DeleteMsg" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
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
                        $staffOut_id=$userDetails['staff_id'];
                        $count=0;
                        while($MeOutRow = $AllUserMsgMOut->fetch_assoc()) {
                            $type=$MeOutRow['type'];
                            $outbox=$MeOutRow['from_user'];
                            if($staffOut_id == $outbox && $type == 'SM'){                           
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
                                    <a href="../controller/contactController.php?status=ViewMsgOut&message_id=<?php echo $MeOutRow['user_message_id']?>&fname=<?php echo $MeOutRow['member_fname']?>&lname=<?php echo $MeOutRow['member_lname']?>" class="btn" style="background-color: #66cc00"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View"></i></i></a>
                                    <a href="../controller/contactController.php?message_id=<?php echo $MeOutRow['user_message_id']?>&status=DeleteMsg" class="btn btn-danger" onclick="return deleteRow()"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
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
        </div>
    </div>
</div>
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>
<!---- Datatables------>
<script type="text/javascript">
            $(document).ready(function() {
                $('table.display').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                } );
            } );
</script>