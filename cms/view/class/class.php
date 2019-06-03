<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../../model/class.php'; ?>
<?php 
$allClass = Programs::displayAllPrograms();
// $row = $allPrograms->fetch_assoc();
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Class</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Trainer</th>
                    <th>Color</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allClass){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allClass->fetch_assoc()) {
                        $count++;
                        
                        if($row['status']==Programs::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Programs::INACTIVE){
                            $status="Inactive";
                        }
                ?>
                <tr>
                    <td><?php echo ucwords($row['class_name']); ?></td>
                    <td><?php echo ucwords($row['trainer_name']); ?></td>
                    <td><?php echo $row['color']; ?></td>
                    <td><span class="badge <?php if($row['status']==Programs::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../controller/classController.php?Programs_id=<?php echo $row['class_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../controller/classController.php?Programs_id=<?php echo $row['class_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $classId = $row['class_id'];

                            if($row['status']==Programs::ACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Deactivate' href='../../controller/classController.php?class_id='.$classId.'&status=Deactivate'><i class='fas fa-ban text-warning'></i></a>";
                            }elseif($row['status']==Programs::INACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Activate' href='../../controller/classController.php?class_id='.$classId.'&status=Activate'><i class='far fa-check-circle text-success'></i></a>";
                            }
                        ?>
                            <a data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Class</th>
                    <th>Trainer</th>
                    <th>Color</th>
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
                },
                {
                text: '+ ADD CLASS',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "addClass.php";
                }
            },
            ],
            select: true
        } );
    } );
</script>