<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../../model/package.php'; ?>
<?php 
$allPackage = Package::displayAllPackage();
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Package</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
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
                    <td><?php if (!empty($row['image'])){echo "<img src='../../../public/image/package_image/{$row['image']}' width='70' height='auto' class='img-responsive img-thumbnail' />";}else{echo "<i class='far fa-3x fa-calendar-check'></i>";}?></td>
                    <td><?php echo ucfirst($row['package_name']); ?></td>
                    <td><?php echo $row['fee']; ?></td>
                    <td><?php echo $row['duration']; ?></td>
                    <td><span class="badge <?php if($row['status']==Package::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                        <a data-toggle="tooltip" data-placement="top" title="View" href="../../../controller/packageController.php?package_id=<?php echo $row['package_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                        <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../../controller/packageController.php?package_id=<?php echo $row['package_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                    <?php 
                        $packageID = $row['package_id'];

                    if($row['status']==Package::ACTIVE){ ?>
                        <a id="Deactivate" data-toggle="tooltip" data-placement="top" title="Deactivate" href="../../../controller/packageController.php?package_id=<?php echo $packageID;?>&status=Deactivate"><i class="fas fa-ban text-warning"></i></a>
                    <?php                            
                    }elseif($row['status']==Package::INACTIVE){ ?>
                        <a id="Activate" data-toggle="tooltip" data-placement="top" title="Activate" href="../../../controller/packageController.php?package_id=<?php echo $packageID;?>&status=Activate"><i class="far fa-check-circle text-success"></i></a>
                    <?php } ?>
                        <a id="Delete" data-toggle="tooltip" data-placement="top" title="Delete" href="../../../controller/packageController.php?package_id=<?php echo $packageID;?>&status=Delete"><i class="fas fa-trash text-danger"></i></a>
                    </td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>Package Name</th>
                    <th>Fee</th>
                    <th>Duration</th>
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
                {
                text: '+ ADD PACKAGE',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "../../../controller/packageController.php?status=Add";
                }
            },
            ],
            select: true
        } );

          // deactivate confirmation
          $('#Deactivate').on('click', function(event){
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
                    var href = $('#Deactivate').attr('href');
                    window.location.href = href;
                    }
                }
            });
        });

    // activate confirmation
        $('#Activate').on('click', function(event){
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
                    var href = $('#Activate').attr('href');
                    window.location.href = href;
                    }
                }
            });
        });

    // delete confirmation
        $('#Delete').on('click', function(event){
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
                    var href = $('#Delete').attr('href');
                    window.location.href = href;
                    }
                }
            });
        });
    } );
</script>