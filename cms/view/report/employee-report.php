<!--- header start ---->
<?php include '../../layout/header.php'; ?>
<!--- header end ---->
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
        <li class="breadcrumb-item" aria-current="pjoined_date"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="index.php">Report</a></li>
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="#">Employee Report</a></li>
    </ol>
    </nav>
    <div class="container">
        <table cellpadding="0" cellspacing="0" border="0" style="width: 50%; margin: 0 auto 2em auto; border-spacing: 5px; border-collapse: separate;">
            <tbody>
                <tr>
                    <td>Minimum Joined Date:</td>
                    <td><input type="text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>Maximum Joined Date:</td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>
            </tbody>
        </table>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Employee Type</th>
                    <th>Joined Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!$allStaff){
                        die("Query DEAD ".mysqli_error($con));
                    }

                    while($row = $allStaff->fetch_assoc()) {
                        
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
                    <td></td>
                    <td><?php echo ucwords($row['first_name']); ?></td>
                    <td><?php echo ucwords($row['last_name']); ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['telephone']; ?></td>
                    <td><?php echo $staffType; ?></td>
                    <td><?php echo $row['joined_date']; ?></td>
                    <td><span class="badge <?php if($row['status']==Staff::ACTIVE){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Employee Type</th>
                    <th>Joined Date</th>
                    <th>Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php include '../../layout/footer.php';?>
<script type="text/javascript">
    
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#min').datepicker("getDate");
            var max = $('#max').datepicker("getDate");
            var startDate = new Date(data[6]);
            if (min == null && max == null) { return true; }
            if (min == null && startDate <= max) { return true;}
            if(max == null && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
            return false;
        }
        );

    $(document).ready(function() {

        $( "#min" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
        });

        $( "#max" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
        });

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
            this.api().columns([5]).every( function () {
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