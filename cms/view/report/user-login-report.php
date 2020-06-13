<?php include '../../layout/header.php'; ?>
<?php include '../../../model/log.php'; ?>
<?php 
$allStaffLog = Log::displayAllStaffLogs();
$allMemberLog = Log::displayAllMemberLogs();
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Log</a></li>
    </ol>
    </nav>
    <div class="container">
      <!-- Staff Log -->
        <table id="" class="display" style="width:100%">
            <thead>
                <tr>
                    <th colspan="6"><span class="badge badge-primary"><h4>STAFF LOG</h4></span></th>
                </tr>
                <tr>
                    <th>Log ID</th>
                    <th>Name</th>
                    <th>Log In(Date & Time)</th>
                    <th>Log Out(Date & Time)</th>
                    <th>IP Address</th>
                    <th>Spent Time</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allStaffLog){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allStaffLog->fetch_assoc()) {
                        $count++;
                        
                        //To get spent time
                        $st1=strtotime($row['log_in']);
                        $st2= strtotime($row['log_out']);
                        $date1=date_create($row['log_in']);
                        $date2=date_create($row['log_out']);
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
                            $text="text-success";
                        }     

                ?>
                <tr>
                    <td><?php echo $row['log_id']; ?></td>
                    <td><?php echo ucwords($row['name']); ?></td>
                    <td><?php echo $row['log_in']; ?></td>
                    <td><?php echo $row['log_out']; ?></td>
                    <td><?php echo $row['log_ip']; ?></td>
                    <td class="<?php echo $text; ?>"><?php echo $stime; ?></td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Log ID</th>
                    <th>Name</th>
                    <th>Log In(Date & Time)</th>
                    <th>Log Out(Date & Time)</th>
                    <th>IP Address</th>
                    <th>Spent Time</th>
                </tr>
            </tfoot>
        </table>
      <!-- Member Log -->
        <table id="" class="display" style="width:100%">
            <thead>
                <tr>
                    <th colspan="6"><span class="badge badge-primary"><h4>MEMBER LOG</h4></span></th>
                </tr>
                <tr>
                    <th>Log ID</th>
                    <th>Name</th>
                    <th>Log In(Date & Time)</th>
                    <th>Log Out(Date & Time)</th>
                    <th>IP Address</th>
                    <th>Spent Time</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allMemberLog){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allMemberLog->fetch_assoc()) {
                        $count++;
                        
                        //To get spent time
                        $st1=strtotime($row['log_in']);
                        $st2= strtotime($row['log_out']);
                        $date1=date_create($row['log_in']);
                        $date2=date_create($row['log_out']);
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
                            $text="text-success";
                        }     
                ?>
                <tr>
                    <td><?php echo $row['log_id']; ?></td>
                    <td><?php echo ucwords($row['name']); ?></td>
                    <td><?php echo $row['log_in']; ?></td>
                    <td><?php echo $row['log_out']; ?></td>
                    <td><?php echo $row['log_ip']; ?></td>
                    <td class="<?php echo $text; ?>"><?php echo $stime; ?></td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Log ID</th>
                    <th>Name</th>
                    <th>Log In(Date & Time)</th>
                    <th>Log Out(Date & Time)</th>
                    <th>IP Address</th>
                    <th>Spent Time</th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php include '../../layout/footer.php';?>
<script type="text/javascript">
    $(document).ready(function() {
      var table = $('table.display').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'csv',
                'excel',
                'pdf',
                {
                    extend: 'print',
                    text: 'Print all',
                    exportOptions: {
                        modifier: {
                            selected: null
                        }
                    }
                }
            ],
            select: false
        } );
    } );
</script>