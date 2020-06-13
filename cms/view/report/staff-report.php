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
        <li class="breadcrumb-item" aria-current="pjoined_date"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="index.php">Report</a></li>
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="#">Staff Report</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-around">
                <div class="col-3 card align-items-center border-success bg-secondary">
                    <h3 class="text-light">ADMINS : <span class="text-warning" id="admin_count"></span></h3>
                </div><br />
                <div class="col-3 card align-items-center border-success bg-secondary">
                    <h3 class="text-light">MANAGERS : <span class="text-warning" id="manager_count"></span></h3>          
                </div><br />
                <div class="col-3 card align-items-center border-success bg-secondary">
                    <h3 class="text-light">TRAINERS : <span class="text-warning" id="trainer_count"></span></h3>
                </div>
            </div>
        </div><hr />
        <div class="row">
            <div class="col-12 d-flex">
                <div id="container" style="min-width: 610px; height: 400px; max-width: 900px; margin: 0 auto"></div>
            </div>
        </div><hr />
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
                    <td><?php echo $status; ?></td>
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
    // https://jsfiddle.net/bindrid/2bkbx2y3/6/
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
            this.api().columns([5,7]).every( function () {
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

        //getting admin count
        getStaffCount();

        // Radialize the colors

        Highcharts.setOptions({
        colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
            };
        })
        });

        // Build the chart
        staffChart = new Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'STAFF'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                connectorColor: 'silver'
            }
            }
        },
        series: [{
            name: 'Share',
            data: [
            { name: 'Admins', y: 0 },
            { name: 'Managers', y: 0 },
            { name: 'Trainers', y: 0 }
            ]
        }]
        });
      
    } );

    // admin count
    function getStaffCount(){
        $.ajax({
            type: "POST",
            url: '../../../controller/reportController.php?status=empCount',
            success: function (returnJSON) {
                try {
                    var JSON = jQuery.parseJSON(returnJSON);
                    if (JSON.Result) {
                        $('#admin_count').html(JSON.Data.admin_count);
                        $('#manager_count').html(JSON.Data.manager_count);
                        $('#trainer_count').html(JSON.Data.trainer_count);

                        // var adminCount = JSON.Data.staff;
                        staffChart.series[0].setData([JSON.Data.admin_count,JSON.Data.manager_count,JSON.Data.trainer_count]);
                    } else {
                        // console.log("lbp");
                        showStatusMessage('Danger','Unknown error occured.','danger');
                    }
                } catch (e) {
                    showStatusMessage('Danger','Unknown error occured.','danger');
                }
            },
            error: function () {
                showStatusMessage('Danger','Unknown error occured.','danger');
            }
        });
    } 

</script>