<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/trainingModel.php'; ?><!-- including staff model ----->
<?php 
// Get All staff members details for the staff tables 
$objtra= new trainings();
$AllTraings = $objtra->displayAllTrainings();

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
                        <li><a href="#" class="active" >Trainings</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Training Programs List</b></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p align="left" style="font-family: monospace; padding-top: 20px">
                        <a href="AddTrainings.php"><button class="btn btn-danger btn-lg" style="padding-bottom: 12px; "><i class="glyphicon glyphicon-user glyphicon-plus"></i>&nbsp; ADD Training</button></a>
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
            </div><hr />
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    <?php if(isset($_REQUEST['msg'])){ 
                        $msg= base64_decode($_REQUEST['msg']);
                    ?>
            <span class="alert alert-success"><?php echo $msg; ?></span>
                                
                    <?php   } ?>
                            
                </div>
            </div><br />
            <div class="row">
                <table id="mytable" class="table table-striped table-dark table-responsive" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">Training Name</th>
                        <th scope="col">Instructor</th>                             
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!$AllTraings){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $count=0;
                        while($traingRow = $AllTraings->fetch_assoc()) {
                            $count++;
                            
                            
                            if($traingRow['training_image']==""){
                                $path="../images/user.png";
                            } else {
                                $path="../images/training_image/".$traingRow['training_image'];
                           
                            }
                            
                            if($traingRow['training_status']=="Active"){
                                $status="Deactive";
                            }else{
                                $status="Active";
                            }
                        ?>
                      <tr <?php  if(isset($_REQUEST['msg']) && $count==1){ ?>
                           class="success" 
                            <?php  } ?>>
                         <td>
                             <img src="<?php echo $path; ?>" width="100" height="auto" class="img-responsive img-thumbnail" />
                          </td>
                          <td><?php echo ucfirst($traingRow['training_name']);?></td>
                        <td><?php echo ucfirst($traingRow['staff_fname'])." ".ucfirst($traingRow['staff_lname']);?></td>
                        
                        <td>
                            <a href="../controller/trainingsController.php?training_id=<?php echo $traingRow['training_id']?>&status=View" class="btn" style="background-color: #66cc00"><span class="glyphicon glyphicon-list"></span></a>
                            <a href="../view/updateTrainings.php?training_id=<?php echo $traingRow['training_id']?>&status=Update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="../controller/trainingsController.php?training_id=<?php echo $traingRow['training_id']?>&status=<?php echo $status; ?>" class="btn btn-danger" onclick="return disConfirm('<?php echo $status; ?>')">
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
                $('#mytable').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                } );
            } );
        </script>