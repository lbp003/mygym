<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
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
                    $count=0;
                    while($row = $allMember->fetch_assoc()) {
                        $count++;
                        
                        
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
                            <a data-toggle="tooltip" data-placement="top" title="View" href="../../controller/memberController.php?member_id=<?php echo $row['member_id']?>&status=View"><i class="far fa-eye text-primary"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title="Edit" href="../../controller/memberController.php?member_id=<?php echo $row['member_id']?>&status=Edit"><i class="fas fa-pencil-alt text-info"></i></a>
                        <?php 

                            $memberId = $row['member_id'];

                            if($row['status']==Member::ACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Deactivate' href='../../controller/memberController.php?member_id='.$memberId.'&status=Deactivate'><i class='fas fa-ban text-warning'></i></a>";
                            }elseif($row['status']==Member::INACTIVE){
                                echo "<a data-toggle='tooltip' data-placement='top' title='Activate' href='../../controller/memberController.php?member_id='.$memberId.'&status=Activate'><i class='far fa-check-circle text-success'></i></a>";
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
                text: '+ ADD MEMBER',
                className: 'btn-success',
                action: function ( e, dt, node, config ) {
                    window.location.href = "addMember.php";
                }
            },
            ],
            select: true
        } );
    } );
</script>