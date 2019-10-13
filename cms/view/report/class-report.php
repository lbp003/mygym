<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../../model/class.php'; ?>
<?php 
$allClass = Programs::displayAllPrograms();
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
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="#">Class Report</a></li>
    </ol>
    </nav>
    <div class="container">
    <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Class</th>
                    <th>Class Description</th>
                    <th>Color</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allClass){
                        die("Query DEAD ".mysqli_error($con));
                    }

                    while($row = $allClass->fetch_assoc()) {

                        if($row['status']==Programs::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Programs::INACTIVE){
                            $status="Inactive";
                        }
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo ucwords($row['class_name']); ?></td>
                    <td><?php echo ucfirst($row['class_description']); ?></td>
                    <td><?php echo $row['color']; ?></td>
                    <td><span class="badge <?php if($row['status']==Programs::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
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