<?php include '../../layout/header.php'; ?>
<?php include '../../../model/staff.php'; ?>
<?php 
$allStaff = Staff::displayAllStaff();
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Staff</a></li>
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
                    if(!$allStaff){
                        die("Query DEAD ".mysqli_error($con));
                    }

                    while($row = $allStaff->fetch_assoc()) {

                        if($row['image']==""){
                            $path="../../../".PATH_IMAGE."user.png";
                        } else {
                            $path="../../../".PATH_IMAGE.PATH_STAFF_IMAGE.$row['image'];                    
                        }
                        
                        if($row['status']==Staff::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Staff::INACTIVE){
                            $status="Inactive";
                        }

                        if($row['staff_type']==Staff::SUPER_ADMIN){
                            $staffType = "Super Admin";
                        }elseif($row['staff_type']==Staff::ADMIN){
                            $staffType = "Admin";
                        }elseif($row['staff_type']==Staff::MANAGER){
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
                    <td><span class="badge <?php if($row['status']==Staff::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../../controller/staffController.php?staff_id=<?php echo $row['staff_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                        <?php if($auth->checkPermissions([Role::MANAGE_STAFF])){?>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../../controller/staffController.php?staff_id=<?php echo $row['staff_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php } 

                        $staffId = $row['staff_id'];
                        
                        if($row['status']==Staff::ACTIVE && $staffId != $user['staff_id']){ ?>
                            <a onclick="deactivate(this.href);" data-toggle="tooltip" data-placement="top" title="Deactivate" href="../../../controller/staffController.php?staff_id=<?php echo $staffId;?>&status=Deactivate"><i class="fas fa-ban text-warning"></i></a>
                        <?php }elseif($row['status']==Staff::INACTIVE && $staffId != $user['staff_id']){ ?>
                            <a onclick="activate(this.href);" data-toggle="tooltip" data-placement="top" title="Activate" href="../../../controller/staffController.php?staff_id=<?php echo $staffId;?>&status=Activate"><i class="far fa-check-circle text-success"></i></a>
                        <?php } 
                         if($auth->checkPermissions([Role::MANAGE_STAFF]) && $staffId != $user['staff_id']){ ?>
                            <a onclick="deleteC(this.href);" data-toggle="tooltip" data-placement="top" title="Delete" href="../../../controller/staffController.php?staff_id=<?php echo $staffId;?>&status=Delete"><i class="fas fa-trash text-danger"></i></a>
                         <?php } ?>
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
                    <th>Staff Type</th>
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
                <?php if($auth->checkPermissions([Role::MANAGE_STAFF])){?>
                {
                text: '+ ADD STAFF',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "add-staff.php";
                }
            },
            <?php } ?>
            ],
            select: false
        } );
    } );

   
</script>