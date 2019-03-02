<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/staffModel.php'; ?><!-- including staff model ----->
<?php 
// Get All staff members details for the staff tables 
$obstaff= new staff();
$AllStaff = $obstaff->displayAllStaff();

?>
    <script>
            function disConfirm(str){
                var r=confirm("Do You Want to "+str+"?");
                if(!r){
                    return false;      
                }
                
            }
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
                        <li><a href="#" class="active" >Staff</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b> Staff List</b></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p align="left" style="font-family: monospace; padding-top: 20px">
                        <a href="addStaff.php"><button class="btn btn-danger btn-lg" style="padding-bottom: 12px; "><i class="glyphicon glyphicon-user glyphicon-plus"></i>&nbsp; ADD STAFF</button></a>
                    </p>    
                </div>
                <div class="col-md-9">&nbsp;
<!--                    <form class="form-inline" style="float: right; padding-top: 20px">
                        <div class="form-group">
                        <label class="sr-only">search</label>
                        <input class="form-control" size="35" type="search" name="search">
                        </div>
                        <button class="btn btn-default" type="submit" name="submit">Search</button>
                    </form>-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="msg" style="text-align: center">
                    <?php if(isset($_REQUEST['msg'])){ 
                        $msg= base64_decode($_REQUEST['msg']);
                    ?>
            <span class="alert alert-success"><?php echo $msg; ?></span>
                                
                    <?php   } ?>
                            
                </div>
            </div><br />
            <div class="row">
                <table id="mytable" class="table table-striped table-responsive" style="width: 100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!$AllStaff){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $count=0;
                        while($staffrow = $AllStaff->fetch_assoc()) {
                            $count++;
                            
                            
                            if($staffrow['staff_image']==""){
                                $path="../images/user.png";
                            } else {
                                $path="../images/staff_image/".$staffrow['staff_image'];
                           
                            }
                            
                            if($staffrow['staff_status']=="Active"){
                                $status="Deactive";
                            }else{
                                $status="Active";
                            }
                        ?>
                      <tr <?php  if(isset($_REQUEST['msg']) && $count==1){ ?>
                           class="success" 
                            <?php  } ?>>
                         <td>
                             <img src="<?php echo $path; ?>" width="70" height="auto" class="img-responsive img-thumbnail" />
                          </td>
                          <td><?php echo ucfirst($staffrow['staff_fname']);?></td>
                        <td><?php echo ucfirst($staffrow['staff_lname']);?></td>
                        <td><?php echo $staffrow['staff_email'];?></td>
                        <td><?php echo ucfirst($staffrow['role_name']);?></td>
                        <td>
                            <a href="../controller/staffcontroller.php?staff_id=<?php echo $staffrow['staff_id']?>&status=View" class="btn" style="background-color: #66cc00"><span class="glyphicon glyphicon-list"></span></a>
                            <a href="../view/updateStaff.php?staff_id=<?php echo $staffrow['staff_id']?>&status=Update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="../controller/staffcontroller.php?staff_id=<?php echo $staffrow['staff_id']?>&status=<?php echo $status; ?>" class="btn btn-danger" onclick="return disConfirm('<?php echo $status; ?>')">
                                <?php echo $status ?>
                            </a>
                        </td>
                      </tr>
                     <?php  } ?>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>
        <script type="text/javascript">
            $(document).ready(function() {
            $("#msg").delay(5000).fadeOut("slow");
            //$('#mytable').DataTable();
                });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#mytable').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                } );
            } );
        </script>