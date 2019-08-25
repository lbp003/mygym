<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../../model/equipment.php'; ?>
<?php 
$allEquipment = Equipment::displayAllEquipment();
// $row = $allequipment->fetch_assoc();
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Equipment</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Equipment Name</th>
                    <th style="width: 40%">Description</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allEquipment){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allEquipment->fetch_assoc()) {
                        $count++;
                        
                        
                        if($row['status']==Equipment::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Equipment::INACTIVE){
                            $status="Inactive";
                        }
                ?>
                <tr>
                    <td><?php if (!empty($row['image'])){echo "<img src='../../../public/image/equipment_image/{$row['image']}' width='70' height='auto' class='img-responsive img-thumbnail' />";}else{echo "<i class='fas fa-dumbbell fa-3x'></i>";}?></td>
                    <td><?php echo ucwords($row['equipment_name']); ?></td>
                    <td><?php echo ucfirst($row['equipment_description']); ?></td>
                    <td><span class="badge <?php if($row['status']==Equipment::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../../controller/equipmentController.php?equipment_id=<?php echo $row['equipment_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../../controller/equipmentController.php?equipment_id=<?php echo $row['equipment_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $equipmentID = $row['equipment_id'];

                            if($row['status']==Equipment::ACTIVE){ ?>
                                <a id="deactivate" data-toggle="tooltip" data-placement="top" title="Deactivate" href="../../../controller/equipmentController.php?equipment_id=<?php echo $equipmentID; ?>&status=Deactivate"><i class="fas fa-ban text-warning"></i></a>
                        <?php
                            }elseif($row['status']==Equipment::INACTIVE){ ?>
                                <a id="activate" data-toggle="tooltip" data-placement="top" title="Activate" href="../../../controller/equipmentController.php?equipment_id=<?php echo $equipmentID; ?>&status=Activate"><i class="far fa-check-circle text-success"></i></a>
                        <?php } ?>
                            <a id="delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>Equipment Name</th>
                    <th style="width: 40%">Description</th>
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
                text: '+ ADD EQUIPMENT',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "../../../controller/equipmentController.php?status=Add";
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