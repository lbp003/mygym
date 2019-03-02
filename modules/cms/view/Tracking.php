<!--header start ---->
<?php include '../common/adHeader.php'; ?>
<?php include '../model/trackingModel.php'; ?><!-- including tracking model ----->
<?php 
// Get All staff loging records 
$objtr= new tracking();
$AllStaffLog = $objtr->displayAllStaffLogs();

// Get All member loging records
$AllMemberLog = $objtr->displayAllMemberLogs();

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
                        <li><a href="#" class="active" >User Tracking</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>User Tracking Records</b></h1>
                    </div>
                </div>
            </div><hr />
            <div class="row">
                <div class="col-md-12">
                  <h2 align="center" style="color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Staff Records</b></h2>  
                </div>
            </div><br />
            <div class="row">
                <table id="" class=" display table table-striped table-responsive" style="width: 100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">Log ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Log In(Date & Time)</th>
                        <th scope="col">Log Out(Date & Time)</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Spent Time</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!$AllStaffLog){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $count=0;
                        while($StLogRow = $AllStaffLog->fetch_assoc()) {
                            $count++;
                            
                            //To get spent time
                            $st1=strtotime($StLogRow['log_in']);
                            $st2= strtotime($StLogRow['log_out']);
                            $date1=date_create($StLogRow['log_in']);
                            $date2=date_create($StLogRow['log_out']);
                            $diff=date_diff($date1,$date2);

                            $tdiff=$st2-$st1;
                            if($tdiff>=0){
                                $stime=$diff->format("%H").":".$diff->format("%I").":".$diff->format("%S");
                              $class="";  

                            }else{ 
                                $cdate=date("Y-m-d h:i:s");
                                $date3= date_create($cdate);
                                $diff1=date_diff($date1,$date3);
                                $stime=$diff1->format("%H").":".$diff1->format("%I").":".$diff1->format("%S");
                              $class="text-success";
                            }                
                 
                        ?>
                      <tr>
                        <td><?php echo $StLogRow['log_id'];?></td>
                        <td>
                              <?php echo ucfirst(substr($StLogRow['staff_fname'],0,1)).". ". ucfirst($StLogRow['staff_lname'])?>
                        </td>
                        <td><?php echo $StLogRow['log_in'];?></td>
                        <td><?php echo $StLogRow['log_out'];?></td>
                        <td><?php echo $StLogRow['log_ip'];?></td>
                        <td class="<?php echo $class; ?>"><?php echo $stime; ?>&nbsp;</td>
                      </tr>
                     <?php  } ?>
                    </tbody>
                  </table><hr />
            <div class="row">
                <div class="col-md-12">
                  <h2 align="center" style="color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Member Records</b></h2>  
                </div>
            </div><br />
            <div class="row">
                <table id="" class="display table table-striped table-responsive" style="width: 100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">Log ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Log In(Date & Time)</th>
                        <th scope="col">Log Out(Date & Time)</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Spent Time</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!$AllMemberLog){
                            die("Query DEAD ".mysqli_error($con));
                        }
                        $count=0;
                        while($MeLogRow = $AllMemberLog->fetch_assoc()) {
                            $count++;
                            
                            //To get spent time
                            $st1=strtotime($MeLogRow['log_in']);
                            $st2= strtotime($MeLogRow['log_out']);
                            $date1=date_create($MeLogRow['log_in']);
                            $date2=date_create($MeLogRow['log_out']);
                            $diff=date_diff($date1,$date2);

                            $tdiff=$st2-$st1;
                            if($tdiff>=0){
                                $stime=$diff->format("%H").":".$diff->format("%I").":".$diff->format("%S");
                              $class="";  

                            }else{ 
                                $cdate=date("Y-m-d h:i:s");
                                $date3= date_create($cdate);
                                $diff1=date_diff($date1,$date3);
                                $stime=$diff1->format("%H").":".$diff1->format("%I").":".$diff1->format("%S");
                              $class="text-success";
                            }                
                 
                        ?>
                      <tr>
                        <td><?php echo $MeLogRow['log_id'];?></td>
                        <td>
                              <?php echo ucfirst(substr($MeLogRow['member_fname'],0,1)).". ". ucfirst($MeLogRow['member_lname'])?>
                        </td>
                        <td><?php echo $MeLogRow['log_in'];?></td>
                        <td><?php echo $MeLogRow['log_out'];?></td>
                        <td><?php echo $MeLogRow['log_ip'];?></td>
                        <td class="<?php echo $class; ?>"><?php echo $stime; ?>&nbsp;</td>
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
<!--        <script>
            $(document).ready(function() {
            $('table.display').DataTable();
                } );
        </script>-->
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