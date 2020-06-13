<?php include '../../layout/header.php'; ?>
<?php include '../../../model/member.php'; ?>
<?php 
$allMember = Member::displayAllMember();
// $row = $allMember->fetch_assoc();
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Member</a></li>
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
                    <th>Package</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allMember){
                        die("Query DEAD ".mysqli_error($con));
                    }

                    while($row = $allMember->fetch_assoc()) {

                        if($row['image']==""){
                            $path="../../../".PATH_IMAGE."user.png";
                        } else {
                            $path="../../../public/image/member_image/".$row['image'];                    
                        }
                        
                        if($row['status']==Member::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Member::INACTIVE){
                            $status="Inactive";
                        }
                ?>
                <tr>
                    <td><img src="<?php echo $path; ?>" width="70" height="auto" class="img-responsive img-thumbnail" /></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['telephone']; ?></td>
                    <td><?php echo $row['package_name'];  ?></td>
                    <td><span class="badge <?php if($row['status']==Member::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                    <td>
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../../controller/memberController.php?member_id=<?php echo $row['member_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                        <?php if($auth->checkPermissions([Role::MANAGE_MEMBER])){?>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../../controller/memberController.php?member_id=<?php echo $row['member_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php } ?>
                        <?php
                        
                        $memberID = $row['member_id'];

                        if($auth->checkPermissions([Role::MANAGE_MEMBER])){
                        if($row['status']==Member::ACTIVE){ ?>
                            <a onclick="deactivate(this.href);" data-toggle="tooltip" data-placement="top" title="Deactivate" href="../../../controller/memberController.php?member_id=<?php echo $memberID;?>&status=Deactivate"><i class="fas fa-ban text-warning"></i></a>
                        <?php }elseif($row['status']==Member::INACTIVE){ ?>
                            <a onclick="activate(this.href);" data-toggle="tooltip" data-placement="top" title="Activate" href="../../../controller/memberController.php?member_id=<?php echo $memberID;?>&status=Activate"><i class="far fa-check-circle text-success"></i></a>
                        <?php }} ?>
                        <?php
                         if($auth->checkPermissions([Role::MANAGE_MEMBER])){ ?>
                            <a onclick="deleteC(this.href);" data-toggle="tooltip" data-placement="top" title="Delete" href="../../../controller/memberController.php?member_id=<?php echo $memberID;?>&status=Delete"><i class="fas fa-trash text-danger"></i></a>
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
                    <th>Package</th>
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
            <?php if($auth->checkPermissions([Role::MANAGE_MEMBER])){?>
                {
                text: '+ ADD MEMBER',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "../../../controller/memberController.php?status=Add";
                }
            },
            <?php } ?>
            ],
            select: false
        } );
    } );
</script>