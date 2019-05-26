<!--- header start ---->
<?php include '../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../model/classSchedule.php'; ?>
<?php 
$allClassSchedule = classSchedule::displayAllClassSchedule();
// $row = $allstaff->fetch_assoc();
// print_r($row); exit;
?>
<body>
    <!---navbar starting ---------->
    <?php include '../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Class Session</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
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
                    if(!$allClassSchedule){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allClassSchedule->fetch_assoc()) {
                        $count++;
                        
                        
                        if($row['status']==classSchedule::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==classSchedule::INACTIVE){
                            $status="Inactive";
                        }

                ?>
                <tr>
                    <td><?php echo ucfirst($row['first_name']); ?></td>
                    <td><?php echo ucfirst($row['last_name']); ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['telephone']; ?></td>
                    <td><?php echo $staffType; ?></td>
                    <td><span class="badge <?php if($row['status']==classSchedule::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../controller/classScheduleController.php?classSchedule_id=<?php echo $row['classSchedule_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../controller/classScheduleController.php?classSchedule_id=<?php echo $row['classSchedule_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $classScheduleId = $row['classSchedule_id'];

                            if($row['status']==classSchedule::ACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Deactivate' href='../../controller/classScheduleController.php?classSchedule_id='.$classScheduleId.'&status=Deactivate'><i class='fas fa-ban text-warning'></i></a>";
                            }elseif($row['status']==classSchedule::INACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Activate' href='../../controller/classScheduleController.php?classSchedule_id='.$classScheduleId.'&status=Activate'><i class='far fa-check-circle text-success'></i></a>";
                            }
                        ?>
                            <a data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>classSchedule Type</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php include '../layout/footer.php';?>
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
                },
                {
                text: '+ ADD CLASS SCHEDULE',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "addClassSchedule.php";
                }
            },
            ],
            select: true
        } );
    } );
</script>