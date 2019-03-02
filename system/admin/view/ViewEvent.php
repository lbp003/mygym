<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ---->
<?php include '../model/eventModel.php'; ?> <!-- including staff model ----->
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $obm = new CommonFun();
    $resultm=$obm->viewRoleModule($role_id);
    //echo $userDetails['gender'].$userDetails['dob'];
    //print_r($resultm);
?>
<?php 

    $event_id = $_REQUEST['event_id'];
    $obevUp = new event();
    $result = $obevUp->displayEvent($event_id);
    if(!$result){
        die("ERROR".mysqli_error($con));
    }
    $resultUpEv =$result->fetch_assoc();
    
    // Create an array for staff record
   // $abc=$result->fetch_assoc();
    //if(!$abc){
   //     die("Query FAILED".mysqli_error($con));
    //} else {
//echo $abc[staff_fname];        
//}
   
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
                        <li><a href="event.php" >Event</a></li>
                        <li><a href="#" class="active">Update Event</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Update Event</b></h1>
                    </div><hr />
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <?php if(isset($_REQUEST['msg'])){ 
                                $msg= base64_decode($_REQUEST['msg']);
                            ?>
                            <span class="alert alert-danger"><?php echo $msg; ?></span>
                                
                            <?php   } ?>
                            
                        </div>
                    </div><br />
                    <form method="post" name="ViewEvent" action="../controller/eventcontroller.php?status=View&event_id=<?php echo $event_id;?>" enctype="multipart/form-data">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php 
                                    if($resultUpEv['event_image']==""){
                                        $path="../images/user.png";
                                    }else{
                                        $path="../images/event_image/".$resultUpEv['event_image'];
                                    }
                                ?>
                                <img  class="img-responsive img-thumbnail center-block" src="<?php echo $path;?>" width="350px" height="auto"/>
                            </div>
                             <div class="form-group">
                                <label for="event_title">Event Title</label>
                                <input name="event_title" type="text" class="form-control" id="etitle" value="<?php echo $resultUpEv['event_title']; ?>" readonly="" disabled="">
                            </div>
                            <div class="form-group">
                                <label for="event_date">Event Date</label>
                                <input type="date" class="form-control" id="etime" name="event_date" value="<?php echo $resultUpEv['event_date']; ?>" disabled="">
                            </div>
                            <div class="form-group">
                                <label for="event_date">Event Venue</label>
                                <input type="text" class="form-control" id="etime" name="event_venue" value="<?php echo $resultUpEv['event_venue']; ?>" disabled="">
                            </div>
                             <div class="form-group">
                                <label for="event_description">Event Description</label>
                                <textarea type="text" class="form-control" id="edes" name="event_description"  rows="15" disabled=""><?php echo $resultUpEv['event_description']; ?></textarea>
                            </div>                      
                            </div>
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-12">
                           <div class="row">
                            <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-4">
                                <a href="event.php" class="btn btn-lg btn-info btn-block" name="back">Okay</a>
                            </div>
                            <div class="col-md-4">&nbsp;</div>
                        </div> 
                        </div>
                    </form>
                </div>
        </div><br />
        </div>
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>