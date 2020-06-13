<?php include '../../layout/header.php'; ?>
<?php include '../../../model/classSession.php'; ?>
<?php 
// $day = "sat";
// $jd=gregoriantojd();
// echo date('w', strtotime($day)); exit;
$allClassSession = Session::displayAllClassSession();
// print_r($allClassSession); exit;
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
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="#">Class Session Report</a></li>
    </ol>
    </nav>
    <div class="container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Session Name</th>
                    <th>Class</th>
                    <th>Trainer</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allClassSession){
                        die("Query DEAD ".mysqli_error($con));
                    }
 
                    while($row = $allClassSession->fetch_assoc()) {
                        
                        if($row['status']==Session::ACTIVE){
                            $status="Active";
                        }elseif($row['status']==Session::INACTIVE){
                            $status="Inactive";
                        }

                ?>
                <tr>
                    <th>&nbsp;</th>
                    <td><?php echo ucwords($row['class_session_name']); ?></td>
                    <td><?php echo ucwords($row['class_name']); ?></td>
                    <td><?php echo ucwords($row['trainer_name']); ?></td>
                    <td><?php echo $row['day']; ?></td>
                    <td><?php echo date('H:i',strtotime($row['start_time'])); ?></td>
                    <td><?php echo date('H:i',strtotime($row['end_time'])); ?></td>
                    <td><?php echo $status; ?></td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>Session Name</th>
                    <th>Class</th>
                    <th>Trainer</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
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
            initComplete: function () {
            this.api().columns([2,3,4,5,7]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
        } );

    } );
</script>