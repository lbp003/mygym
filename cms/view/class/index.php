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
                    <th>&nbsp;</th>
                    <th style="width :15%">Class</th>
                    <th>Class Description</th>
                    <th style="width :10%">Color</th>
                    <th style="width :10%">Status</th>
                    <th style="width :10%">&nbsp;</th>
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

                        if($row['image']==""){
                            $path="../../../".PATH_IMAGE."user.png";
                        } else {
                            $path="../../../public/image/class_image/".$row['image'];                    
                        }
                ?>
                <tr>
                    <td><img src="<?php echo $path; ?>" width="70" height="auto" class="img-responsive img-thumbnail" /></td>
                    <td><?php echo ucwords($row['class_name']); ?></td>
                    <td><?php echo ucfirst($row['class_description']); ?></td>
                    <td><?php echo $row['color']; ?></td>
                    <td><span class="badge <?php if($row['status']==Programs::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../../controller/classController.php?class_id=<?php echo $row['class_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../../controller/classController.php?class_id=<?php echo $row['class_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $classID = $row['class_id'];

                            if($row['status']==Programs::ACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Deactivate' href='../../controller/classController.php?class_id='.$classID.'&status=Deactivate'><i class='fas fa-ban text-warning'></i></a>";
                            }elseif($row['status']==Programs::INACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Activate' href='../../controller/classController.php?class_id='.$classID.'&status=Activate'><i class='far fa-check-circle text-success'></i></a>";
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
                    <th>Class</th>
                    <th>Class Description</th>
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
                    window.location.href = "../../../controller/classController.php?status=Add";
                }
            },
            ],
            select: true
        } );

    // deactivate confirmation
        $('#deactivate').on('click', function(event){
            event.preventDefault();
                bootbox.confirm({
                message: "Are you sure that you want to Deactivate ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                    var href = $('#deactivate').attr('href');
                    window.location.href = href;
                    }
                }
            });
        });

    //    activate confirmation
        $('#activate').on('click', function(event){
            event.preventDefault();
                bootbox.confirm({
                message: "Are you sure that you want to Activate ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                    var href = $('#activate').attr('href');
                    window.location.href = href;
                    }
                }
            });
        });

    // delete confirmation
        $('#delete').on('click', function(event){
            event.preventDefault();
                bootbox.confirm({
                message: "Are you sure that you want to Delete ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                    var href = $('#delete').attr('href');
                    window.location.href = href;
                    }
                }
            });
        });
    } );
</script>