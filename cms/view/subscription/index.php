<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/membershipModel.php'; ?><!-- including staff model ----->
<?php 
// Get All item details for the item tables 
$objsm= new membership();
$allSm = $objsm->displayAllMembership();

?>
    <script>
            function disConfirm(str){
                var r=confirm("Do You Want to "+str+"?");
                if(!r){
                    return false;
                    
                }
                
            }      
            function deleteRow(){
                var r=confirm("Do you want to DELETE the message ?");
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
                        <li><a href="#" class="active">subscription</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Subscription List</b></h1>
                    </div>
                </div>
            </div>
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
                        <th scope="col">Name</th>
                        <th scope="col">Package</th>  
                        <th scope="col">Previous Subscription</th>
                        <th scope="col">Next Subscription</th>                  
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!$allSm){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        while($smRow = $allSm->fetch_assoc()) {
                            
                            $status = $smRow['status'];
                            
                            if($smRow['status']=="Active"){
                                $status="Deactive";
                            }else{
                                $status="Active";
                            }
                            
                          ?>
                      <tr 
                          <?php if($smRow['status'] == "Deleted"){?>
                          style="display: none"
                          <?php }?>>
                        <td><?php echo ucfirst($smRow['member_fname']). " ".ucfirst($smRow['member_lname']);?></td>
                        <td><?php echo ucfirst($smRow['package_name']);?></td>
                        <td><?php echo $smRow['start_date'];?></td>
                        <td><?php echo $smRow['end_date'];?></td>
                        <td><?php echo $smRow['status'];?></td>
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
