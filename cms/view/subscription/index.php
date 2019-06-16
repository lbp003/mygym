<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../../model/subscription.php'; ?>
<?php 
$allSubscription = Subscription::displayAllSubscription();
// $row = $allSubscription->fetch_assoc();
// print_r($row); exit;
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Subscription</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Package</th>
                    <th>Start Date</th>
                    <th>Next Payment</th>
                    <th>Last Paid Date</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allSubscription){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allSubscription->fetch_assoc()) {
                        $count++;
                        
                        
                        if($row['payment_status']==Subscription::PAID){
                            $status="Paid";
                        }elseif($row['payment_status']==Subscription::LATE){
                            $status="Late";
                        }
                ?>
                <tr>
                    <td><?php echo ucwords($row['member_name']); ?></td>
                    <td><?php echo ucwords($row['package_name']); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['start_date'])); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['end_date'])); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['last_paid_date'])); ?></td>
                    <td><span class="badge <?php if($row['payment_status']==Subscription::PAID){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../controller/membershipController.php?membership_id=<?php echo $row['membership_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../controller/membershipController.php?membership_id=<?php echo $row['membership_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $membershipId = $row['membership_id'];

                            if($row['status']==Subscription::ACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Deactivate' href='../../controller/membershipController.php?membership_id='.$membershipId.'&status=Deactivate'><i class='fas fa-ban text-warning'></i></a>";
                            }elseif($row['status']==Subscription::INACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Activate' href='../../controller/membershipController.php?membership_id='.$membershipId.'&status=Activate'><i class='far fa-check-circle text-success'></i></a>";
                            }
                        ?>
                            <a data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Member</th>
                    <th>Package</th>
                    <th>Start Date</th>
                    <th>Next Payment</th>
                    <th>Last Paid Date</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php include '../../layout/footer.php';?>
<script type="text/javascript">
    $(document).ready(function() {
      var table = $('#example').DataTable( {
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
            select: true
        } );
    } );
</script>