<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../../model/subscription.php'; ?>
<?php 
$allSubscription = Subscription::displayAllSubscription();
// $row = $allstaff->fetch_assoc();
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
                    <th>&nbsp;</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>User Type</th>
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
                        
                        
                        if($row['status']==Subscription::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Subscription::INACTIVE){
                            $status="Inactive";
                        }

                        if($row['staff_type']==Subscription::SUPER_ADMIN){
                            $staffType = "Super Admin";
                        }elseif($row['staff_type']==Subscription::ADMIN){
                            $staffType = "Admin";
                        }elseif($row['staff_type']==Subscription::MANAGER){
                            $staffType = "Manager";
                        }else{
                            $staffType = "Trainer";
                        }
                ?>
                <tr>
                    <td><img src="<?php echo $path; ?>" width="70" height="auto" class="img-responsive img-thumbnail" /></td>
                    <td><?php echo ucwords($row['first_name']); ?></td>
                    <td><?php echo ucwords($row['last_name']); ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['telephone']; ?></td>
                    <td><?php echo $staffType; ?></td>
                    <td><span class="badge <?php if($row['status']==Subscription::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../controller/staffController.php?staff_id=<?php echo $row['staff_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../controller/staffController.php?staff_id=<?php echo $row['staff_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $staffId = $row['staff_id'];

                            if($row['status']==Subscription::ACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Deactivate' href='../../controller/staffController.php?staff_id='.$staffId.'&status=Deactivate'><i class='fas fa-ban text-warning'></i></a>";
                            }elseif($row['status']==Subscription::INACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Activate' href='../../controller/staffController.php?staff_id='.$staffId.'&status=Activate'><i class='far fa-check-circle text-success'></i></a>";
                            }
                        ?>
                            <a data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Subscription Type</th>
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