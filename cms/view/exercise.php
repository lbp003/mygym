<!--- header start ---->
<?php include '../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../model/exercise.php'; ?>
<?php 
$allExercise = Exercise::displayAllExercise();
// $row = $allexercise->fetch_assoc();
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Exercise</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Excercise Name</th>
                    <th>Anatomy Name</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allExercise){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allExercise->fetch_assoc()) {
                        $count++;
                        
                        if($row['status']==Exercise::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Exercise::INACTIVE){
                            $status="Inactive";
                        }

                ?>
                <tr>
                    <td><?php echo ucwords($row['exercise_name']); ?></td>
                    <td><?php echo ucwords($row['anatomy_name']); ?></td>
                    <td><span class="badge <?php if($row['status']==Exercise::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../controller/exerciseController.php?exercise_id=<?php echo $row['exercise_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../controller/exerciseController.php?exercise_id=<?php echo $row['exercise_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $exerciseId = $row['exercise_id'];

                            if($row['status']==Exercise::ACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Deactivate' href='../../controller/exerciseController.php?exercise_id='.$exerciseId.'&status=Deactivate'><i class='fas fa-ban text-warning'></i></a>";
                            }elseif($row['status']==Exercise::INACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Activate' href='../../controller/exerciseController.php?exercise_id='.$exerciseId.'&status=Activate'><i class='far fa-check-circle text-success'></i></a>";
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
                    <th>Exercise Name</th>
                    <th>Anatomy Name</th>
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
                text: '+ ADD EXERCISE',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "addExercise.php";
                }
            },
            ],
            select: true
        } );
    } );
</script>