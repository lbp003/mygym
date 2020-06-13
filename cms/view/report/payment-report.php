<?php include '../../layout/header.php'; ?>
<?php include '../../../model/subscription.php'; ?>
<?php 
$allSubscription = Subscription::displayAllPaymentHistory();
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
        <li class="breadcrumb-item active" aria-current="pjoined_date"><a href="#">Payment Report</a></li>
    </ol>
    </nav>
    <div  class="container">
        <div class="row">
            <div class="col-12">
                <div id="container"></div><hr />
            </div>
        </div>
    </div>
    <div  class="container">
        <div class="row">
            <div class="col-12 d-flex flex-row">
                <div class="col-6">
                    <div id="container1"></div>
                </div>
                <div class="col-6">
                    <div id="container2"></div>
                </div>
            </div>
            <hr />
        </div>
    </div>
    <div class="container">
    <table cellpadding="0" cellspacing="0" border="0" style="width: 50%; margin: 0 auto 2em auto; border-spacing: 5px; border-collapse: separate;">
            <tbody>
                <tr>
                    <td>Minimum Due Date:</td>
                    <td><input type="text" id="min" name="min" autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Maximum Due Date:</td>
                    <td><input type="text" id="max" name="max" autocomplete="off"></td>
                </tr>
            </tbody>
        </table>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Member</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Currency Type</th>
                    <th>Due Date</th>
                    <th>Paid Date</th>
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
                        
                        
                        if($row['status']==Subscription::SUCCESS){
                            $status="Success";
                        }elseif($row['status']==Subscription::FAILED){
                            $status="Failed";
                        }

                        if($row['payment_method']==Subscription::WEB){
                            $method="Online";
                        }elseif($row['payment_method']==Subscription::CASH){
                            $method="Cash";
                        }
                ?>
                <tr>
                    <th>&nbsp;</th>
                    <td><?php echo ucwords($row['member_name']); ?></td>
                    <td><?php echo $method; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['currency_type']; ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['due_date'])); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['paid_date'])); ?></td>
                    <td><?php echo $status; ?></td>
                </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>Member</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Currency Type</th>
                    <th>Due Date</th>
                    <th>Paid Date</th>
                    <th>Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php include '../../layout/footer.php';?>
<script type="text/javascript">

var web = [];
var cash = [];
var momo = [];
var webSum = [];
var cashSum = [];

function getPaymentData(){
    $.ajax({
        type: "POST",
        url: '../../../controller/reportController.php?status=PaymentData',
        success: function (returnJSON) {
            try {
                var JSON = jQuery.parseJSON(returnJSON);
                
                if (JSON.Result) {
                    momo = JSON.Data.xAxis;
                    web = JSON.Data.web.map(Number);
                    cash = JSON.Data.cash.map(Number);

                    drawChart(momo,web,cash);

                } else {
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

function drawChart(momo,web,cash){
    Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Completed Payment Count'
            },
            xAxis: {
                categories: momo
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Count of members'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Online',
                data: web
            }, {
                name: 'Cash',
                color: '#00ff00',
                data: cash
            }]
        });
    }

    function getRevenueData(){
        $.ajax({
            type: "POST",
            url: '../../../controller/reportController.php?status=revenueData',
            success: function (returnJSON) {
                try {
                    var JSON = jQuery.parseJSON(returnJSON);
                    
                    if (JSON.Result) {
                        momo = JSON.Data.xAxis;
                        webSum = JSON.Data.web.map(Number);
                        console.log(webSum);
                        cashSum = JSON.Data.cash.map(Number);

                        drawRevenueChart(momo,webSum,cashSum);

                    } else {
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

    //revenue chart
    function drawRevenueChart(momo,webSum,cashSum){
        Highcharts.chart('container1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Online Payments Monthly Revenue (USD)'
            },
            xAxis: {
                categories: momo,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Amount (USD)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Online',
                data: webSum

            }]
        });

        Highcharts.chart('container2', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Cash Payments Monthly Revenue (LKR)'
            },
            xAxis: {
                categories: momo,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Amount (LKR)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Cash',
                color: '#00ff00',
                data: cashSum

            }]
        });
    }

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

    getPaymentData();
    getRevenueData();

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
            this.api().columns([2,7]).every( function () {
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