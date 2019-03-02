<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/packageModel.php'; ?><!-- including package model ----->
<?php 
// Get All staff members details for the staff tables 
$objpac= new package();
$AllPackage = $objpac->displayAllPackage();

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
                        <li><a href="#" class="active" >Package</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Package List</b></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p align="left" style="font-family: monospace; padding-top: 20px">
                        <a href="AddPackage.php"><button class="btn btn-danger btn-lg" style="padding-bottom: 12px; "><i class="glyphicon glyphicon-user glyphicon-plus"></i>&nbsp; ADD Package</button></a>
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
                        <th scope="col">Package Name</th>
                        <th scope="col">Ammount(Rs)</th>
                        <th scope="col">Duration</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!$AllPackage){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $count=0;
                        while($packageRow = $AllPackage->fetch_assoc()) {
                            $count++;
                            
                            
                            if($packageRow['package_image']==""){
                                $path="../images/user.png";
                            } else {
                                $path="../images/package_image/".$packageRow['package_image'];
                           
                            }
                            
                            if($packageRow['package_status']=="Active"){
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
                        <td><?php echo ucfirst($packageRow['package_name']);?></td>
                        <td><?php echo $packageRow['price'];?></td>
                        <td><?php echo $packageRow['duration'];?></td> 
                        <td>
                            <a href="../controller/packageController.php?package_id=<?php echo $packageRow['package_id']?>&status=View" class="btn" style="background-color: #66cc00"><span class="glyphicon glyphicon-list"></span></a>
                            <a href="../view/updatePackage.php?package_id=<?php echo $packageRow['package_id']?>&status=Update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="../controller/packageController.php?package_id=<?php echo $packageRow['package_id']?>&status=<?php echo $status; ?>" class="btn btn-danger" onclick="return disConfirm('<?php echo $status; ?>')">
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