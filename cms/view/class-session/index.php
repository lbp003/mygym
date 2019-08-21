<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../../model/classSession.php'; ?>
<?php 
$allClassSession = classSession::displayAllClassSession();
// print_r($allClassSession); exit;
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Class Session</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Session Name</th>
                    <th>Class</th>
                    <th>Trainer</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allClassSession){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allClassSession->fetch_assoc()) {
                        $count++;
                        
                        
                        if($row['status']==classSession::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==classSession::INACTIVE){
                            $status="Inactive";
                        }

                ?>
                <tr>
                    <td><?php echo ucwords($row['class_session_name']); ?></td>
                    <td><?php echo ucwords($row['class_name']); ?></td>
                    <td><?php echo ucwords($row['trainer_name']); ?></td>
                    <td><?php echo $row['day']; ?></td>
                    <td><?php echo $row['start_time']; ?></td>
                    <td><?php echo $row['end_time']; ?></td>
                    <td><span class="badge <?php if($row['status']==classSession::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../controller/classSessionController.php?classSession_id=<?php echo $row['classSession_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../controller/classSessionController.php?classSession_id=<?php echo $row['classSession_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $classSessionID = $row['class_session_id'];

                            if($row['status']==classSession::ACTIVE){ ?>
                                <a id="deactivate" data-toggle="tooltip" data-placement="top" title="Deactivate" href="../../controller/classSessionController.php?classSession_id=<?php echo $classSessionID;?>&status=Deactivate"><i class="fas fa-ban text-warning"></i></a>
                            <?php
                            }elseif($row['status']==classSession::INACTIVE){ ?>
                                <a id="activate" data-toggle="tooltip" data-placement="top" title="Activate" href="../../controller/classSessionController.php?classSession_id=<?php echo $classSessionID;?>&status=Activate"><i class="far fa-check-circle text-success"></i></a>
                            <?php
                            }
                        ?>
                            <a id="delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Session Name</th>
                    <th>Class</th>
                    <th>Trainer</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
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
                text: '+ ADD CLASS SESSION',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "../../../controller/classSessionController.php?status=Add";
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