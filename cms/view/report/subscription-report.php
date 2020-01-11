<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../../model/subscription.php'; ?>
<?php 
$allSubscription = Subscription::displayAllSubscription();
// $row = $allSubscription->fetch_assoc();
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
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="#">Subscription Report</a></li>
    </ol>
    </nav>
    <div class="container">
    <table cellpadding="0" cellspacing="0" border="0" style="width: 50%; margin: 0 auto 2em auto; border-spacing: 5px; border-collapse: separate;">
            <tbody>
                <tr>
                    <td>Minimum Last Paid Date:</td>
                    <td><input type="text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>Maximum Last Paid Date:</td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>
            </tbody>
        </table>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Member</th>
                    <th>Package</th>
                    <th>Start Date</th>
                    <th>Next Payment Date</th>
                    <th>Last Paid Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allSubscription){
                        die("Query DEAD ".mysqli_error($con));
                    }
                    $count=0;
                    while($row = $allSubscription->fetch_assoc()) {
                        $count++;
                        
                        
                        if($row['payment_status']==Subscription::PAID){
                            $status="Paid";
                        }elseif($row['payment_status']==Subscription::LATE){
                            $status="Late";
                        }elseif($row['payment_status']==Subscription::PENDING) {
                            $status="Pending";
                        }
                ?>
                <tr>
                    <th>&nbsp;</th>
                    <td><?php echo ucwords($row['member_name']); ?></td>
                    <td><?php echo ucwords($row['package_name']); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['start_date'])); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['end_date'])); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['last_paid_date'])); ?></td>
                    <td><?php echo $status; ?></td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>Member</th>
                    <th>Package</th>
                    <th>Start Date</th>
                    <th>Next Payment</th>
                    <th>Last Paid Date</th>
                    <th>Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php include '../../layout/footer.php';?>
<script type="text/javascript">

 // https://jsfiddle.net/bindrid/2bkbx2y3/6/
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#min').datepicker("getDate");
            var max = $('#max').datepicker("getDate");
            var startDate = new Date(data[5]);
            if (min == null && max == null) { return true; }
            if (min == null && startDate <= max) { return true;}
            if(max == null && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
            return false;
        }
    );

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
                }
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
            this.api().columns([2,6]).every( function () {
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

        $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
        $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });

        $('#min, #max').change(function () {
                table.draw();
        });
    } );
</script>