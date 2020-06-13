<?php include '../../layout/header.php'; ?>
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
        <li class="breadcrumb-item" aria-current="pjoined_date"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="index.php">Report</a></li>
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="#">Package Report</a></li>
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
                    <td>&nbsp;</td>
                    <td><?php echo ucfirst($row['package_name']); ?></td>
                    <td><?php echo $row['fee']; ?></td>
                    <td><?php echo $row['duration']; ?></td>
                    <td><span class="badge <?php if($row['status']==Package::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
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
            ],
            columnDefs: [ {
                orderable: false,
                className: 'select-checkbox',
                targets:   0
                } 
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
        } );
    } );
</script>