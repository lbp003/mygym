<!--- header start ---->
<?php include '../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../model/package.php'; ?>
<?php 
$allPackage = Package::displayAllPackage();
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Package</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Package Name</th>
                    <th>Fee</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allPackage){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allPackage->fetch_assoc()) {
                        $count++;
                        
                        if($row['status']==Package::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Package::INACTIVE){
                            $status="Inactive";
                        }
                ?>
                <tr>
                    <td><?php echo ucfirst($row['package_name']); ?></td>
                    <td><?php echo ucfirst($row['fee']); ?></td>
                    <td><?php echo $row['duration']; ?></td>
                    <td><span class="badge <?php if($row['status']==Package::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../controller/packageController.php?package_id=<?php echo $row['package_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../controller/packageController.php?package_id=<?php echo $row['package_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $packageId = $row['package_id'];

                            if($row['status']==Package::ACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Deactivate' href='../../controller/packageController.php?package_id='.$packageId.'&status=Deactivate'><i class='fas fa-ban text-warning'></i></a>";
                            }elseif($row['status']==Package::INACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Activate' href='../../controller/packageController.php?package_id='.$packageId.'&status=Activate'><i class='far fa-check-circle text-success'></i></a>";
                            }
                        ?>
                            <a data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Package Name</th>
                    <th>Fee</th>
                    <th>Duration</th>
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
                text: '+ ADD PACKAGE',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "addPackage.php";
                }
            },
            ],
            select: true
        } );
    } );
</script>