<!--- header start ---->
<?php include_once '../../layout/default_header.php'; ?>
<?php include_once '../../../model/member.php'; ?>
<!--- header end ----> 
<?php 
    $memberID = $_SESSION['user']['member_id'];
    $gender = $_SESSION['user']['gender'];
?>
<?php
    $result = Member::getBMIDataById($memberID);
    while ($row = $result->fetch_assoc()) {
        extract($row);
        $date = strtotime($date);
        $date *= 1000; // convert from Unix timestamp to JavaScript time
        $data[] = "[$date, $bmi_value]";
    }

    $resultb = Member::getBFDataById($memberID);
    while ($row = $resultb->fetch_assoc()) {
        extract($row);
        $date = strtotime($date);
        $date *= 1000; // convert from Unix timestamp to JavaScript time
        $datab[] = "[$date, $bodyfat]";
    }
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/default_navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Home</li>
    </ol>
    </nav>
    <!-- module container -->
    <div class="container">
        <div class="row">   
            <div class="col-12 d-flex flex-row">
                <div class="col-3">
                    <h3>BMI</h3>
                    <p>Your BMI:</p>
                    <div id="result"></div>
                    <div id="bmi_status"></div>
                </div>
                <div class="col-3">
                    <form method="post" id="bmi" name="bmi" action="#"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="weight">Weight</label>
                        <input type="text" name="weight" class="form-control" id="weight" aria-describedby="weight" placeholder="70">
                    </div>
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="text" class="form-control" id="height" name="height" placeholder="1.72">
                    </div>
                    <button id="calculate" class="btn btn-primary">Calculate</button>     
                    <input type="hidden" name="bmiValue" value="" id="">            
                    <input type="hidden" name="member_id" value="<?php echo $memberID;?>">      
                    <button type="submit" id="save" class="btn btn-success" onclick="saveBMI()">Save</button>                    
                    </form>
                </div>  
                <div class="col-6">
                    <ul class="list-group list-group-flush">
                        <li id="underweight" class="list-group-item list-group-item-danger list-group-item-action">Below 18.5 – You're in the underweight range</li>
                        <li id="healthy" class="list-group-item list-group-item-success list-group-item-action">Between 18.5 and 24.9 – You're in the healthy weight range</li>
                        <li id="overweight" class="list-group-item list-group-item-warning list-group-item-action">Between 25 and 29.9 – You're in the overweight range</li>
                        <li id="obese" class="list-group-item list-group-item-danger list-group-item-action">Between 30 and 39.9 – You're in the obese range</li>
                    </ul>
                </div>
            </div>      
        </div>
        <hr />
    </div>
    <div class="container-flud">
        <div class="row">
            <div class="col-12" style="background-color: #F8F9FA">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                    <p class="highcharts-description">
                        Above line chart showing trends of your BMI.
                    </p>
                </figure>
            </div>
        </div>
    </div>
    <div class="container">
    <hr />
        <div class="row">
            <div class="col-12 d-flex flex-row">
                <div class="col-6">
                    <h3 class="text-uppercase">Check Your Body Fat</h3>
                    <small>Measure the following skinfolds (in millimeters) with body fat calipers:</small>
                    <form method="post" id="bfrm" action="#"  enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="chest">Chest</label>
                            <input type="text" name="chest" class="form-control" id="chest">
                        </div>
                        <div class="form-group">
                            <label for="axila">Axila</label>
                            <input type="text" class="form-control" id="axila" name="axila">
                        </div>
                        <div class="form-group">
                            <label for="tricep">Tricep</label>
                            <input type="text" class="form-control" id="tricep" name="tricep">
                        </div>
                        <div class="form-group">
                            <label for="subscapular">Subscapular</label>
                            <input type="text" class="form-control" id="subscapular" name="subscapular">
                        </div>
                        <div class="form-group">
                            <label for="abdominal">Abdominal</label>
                            <input type="text" class="form-control" id="abdominal" name="abdominal">
                        </div>
                        <div class="form-group">
                            <label for="suprailiac">Suprailiac</label>
                            <input type="text" class="form-control" id="suprailiac" name="suprailiac">
                        </div>
                        <div class="form-group">
                            <label for="thigh">Thigh</label>
                            <input type="text" class="form-control" id="thigh" name="thigh">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" class="form-control" id="age" name="age">
                        </div>
                        <input type="hidden" name="bfValue" value="">            
                        <input type="hidden" name="member_id" value="<?php echo $memberID;?>"> 
                        <button id="cte" class="btn btn-primary">Calculate</button>          
                        <button type="submit" id="bfSave" class="btn btn-success" onclick="saveBodyFat()">Save</button>                    
                    </form>
                </div>
                <div class="col-6">
                    <h3 class="text-center" style="margin-top: 50%;">Body Fat Percentage (%)</h3>
                    <p class="text-center">Your Body Fat:</p>
                    <div class="text-center" id="resultbf"></div>
                    <div class="text-center" id="bf_status"></div>
                </div>
            </div>
        </div>
        <hr />
    </div>
    <div class="container-flud">
        <div class="row">
            <div class="col-12" style="background-color: #F8F9FA">
                <figure class="highcharts-figure">
                    <div id="container1"></div>
                    <p class="highcharts-description">
                        Above line chart showing trends of your BMI.
                    </p>
                </figure>
            </div>
        </div>
    </div>
<?php include_once '../../layout/default_footer.php';?>
<script>
    $( document ).ready(function() {
        var bmiData = [];
        var chartData = [];
        var date = "";
        var year = "";
        var month = "";
        var day = "";
        var bmiValue = "";

        //bmi chart start
        Highcharts.chart('container', {
            chart: {
                type: 'spline',
                backgroundColor: '#F8F9FA'
            },
            title: {
                text: 'BMI Chart'
            },
            subtitle: {
                text: 'Check your progress'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'BMI Value'
                },
                min: 0
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true
                    }
                }
            },

            colors: ['#6CF'],

            series: [{
                name: "BMI CHART",
                data: [<?php echo join($data, ',') ?>]
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 700
                    },
                    chartOptions: {
                        plotOptions: {
                            series: {
                                marker: {
                                    radius: 2.5
                                }
                            }
                        }
                    }
                }]
            }
        }); 
        //bmi chart end

        //body fat chart start
        Highcharts.chart('container1', {
            chart: {
                type: 'spline',
                backgroundColor: '#F8F9FA'
            },
            title: {
                text: 'BMI Chart'
            },
            subtitle: {
                text: 'Check your progress'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'BMI Value'
                },
                min: 0
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: true
                    }
                }
            },

            colors: ['#6CF'],

            series: [{
                name: "Body Fat CHART",
                data: [<?php echo join($datab, ',') ?>]
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 700
                    },
                    chartOptions: {
                        plotOptions: {
                            series: {
                                marker: {
                                    radius: 2.5
                                }
                            }
                        }
                    }
                }]
            }
        }); 
        //bmi chart end

        // Calculate bmi
        var calculate = $('#calculate');
        var result = $('#result');

        calculate.on('click', function(e){
            e.preventDefault();

            $('.list-group li.active').removeClass('active');
            var weight = $('#weight').val();
            var height = $('#height').val();
    
            w = weight;
            h = height;

            
            result = w/(h*h);
            result = result.toFixed(2);
            $('input[name="bmiValue"]').val(result);
            $("#result").html("<h1>"+result+"</h1>");

            var bmi_status = "";
            if(result < 18.5){
                bmi_status = "Underweight"; 
                $("#bmi_status").html("<h3><span class='badge badge-danger'>"+bmi_status+"</span></h3>");
                $("#underweight").addClass("active");
                
            }else if(result >= 18.5 && result <= 24.9){
                bmi_status = "Normal weight"; 
                $("#bmi_status").html("<h3><span class='badge badge-success'>"+bmi_status+"</span></h3>");
                $("#healthy").addClass("active");
                
            }else if(result >= 25 && result <= 29.9){
                bmi_status = "Overweight"; 
                $("#bmi_status").html("<h3><span class='badge badge-warning'>"+bmi_status+"</span></h3>");
                $("#overweight").addClass("active");
            }else if(result = 30 && result > 30){
                bmi_status = "Obesity"; 
                $("#bmi_status").html("<h3><span class='badge badge-danger'>"+bmi_status+"</span></h3>");
                $("#obese").addClass("active");
            }

        });

        $('#bf').validate({
            rules: {
                chest: {
                    required: true,
                    number: true
                },
                axila: {
                    required: true,
                    number: true
                },
                tricep: {
                    required: true,
                    number: true
                },
                subscapular: {
                    required: true,
                    number: true
                },
                abdominal: {
                    required: true,
                    number: true
                },
                suprailiac: {
                    required: true,
                    number: true
                },
                suprailiac: {
                    required: true,
                    number: true
                },
                thigh: {
                    required: true,
                    number: true
                },
                age: {
                    required: true,
                    number: true
                },
                bfValue: {
                    required: true,
                    number: true
                }
            },
            messages: {
                chest: {
                    required: "Please enter chest"
                },
                axila: {
                    required: "Please enter axila"
                },
                axila: {
                    required: "Please enter axila"
                },
                tricep: {
                    required: "Please enter tricep"
                },
                subscapular: {
                    required: "Please enter subscapular"
                },
                abdominal: {
                    required: "Please enter abdominal"
                },
                suprailiac: {
                    required: "Please enter suprailiac"
                },
                thigh: {
                    required: "Please enter thigh"
                },
                age: {
                    required: "Please enter age"
                },
                bmiValue: {
                    required: "Please calculate body fat before save"
                }
            }
        });

        // Calculate body fat
        var cte = $('#cte');
        var resultbf = $('#bfresult');

        cte.on('click', function(e){
            e.preventDefault();

            // $('.list-group li.active').removeClass('active');
            var chest = $('#chest').val();
            var axila = $('#axila').val();
            var tricep = $('#tricep').val();
            var subscapular = $('#subscapular').val();
            var abdominal = $('#abdominal').val();
            var suprailiac = $('#suprailiac').val();
            var thigh = $('#thigh').val();
            var age = $('#age').val();

            var density = "";
            var bf_status = "";
            var sum = parseFloat(chest) + parseFloat(axila) + parseFloat(tricep) + parseFloat(subscapular) + parseFloat(abdominal) + parseFloat(suprailiac) + parseFloat(thigh);

            <?php if($gender == "M"){?>
                density = 1.112 - (0.00043499 * sum) + (0.00000055 * Math.pow(sum, 2)) - (0.00028826 * parseFloat(age));
                resultbf = (495 / density) - 450;
                resultbf = resultbf.toFixed(2);
                
                if(resultbf < 12){
                    bf_status = "Lean"; 
                    $("#bf_status").html("<h3><span class='badge badge-danger'>"+bf_status+"</span></h3>");

                }else if(resultbf >= 12 && resultbf < 21){
                    bf_status = "Acceptable"; 
                    $("#bf_status").html("<h3><span class='badge badge-success'>"+bf_status+"</span></h3>");
                    
                }else if(resultbf >= 21 && resultbf <= 26){
                    bf_status = "Moderately Overweight"; 
                    $("#bf_status").html("<h3><span class='badge badge-warning'>"+bf_status+"</span></h3>");
   
                }else if(resultbf > 26){
                    bf_status = "Overweight"; 
                    $("#bf_status").html("<h3><span class='badge badge-danger'>"+bf_status+"</span></h3>");

                }
            <?php }else{ ?>
                density = 1.097 - (0.00046971 * sum) + (0.00000056 * Math.pow(sum, 2)) - (0.00012828 * parseFloat(age));
                resultbf =  (495 / density) - 450;
                resultbf = resultbf.toFixed(2);

                if(resultbf < 17){
                    bf_status = "Lean"; 
                    $("#bf_status").html("<h3><span class='badge badge-danger'>"+bf_status+"</span></h3>");

                }else if(resultbf >= 17 && resultbf < 28){
                    bf_status = "Acceptable"; 
                    $("#bf_status").html("<h3><span class='badge badge-success'>"+bf_status+"</span></h3>");
                    
                }else if(resultbf >= 28 && resultbf <= 33){
                    bf_status = "Moderately Overweight"; 
                    $("#bf_status").html("<h3><span class='badge badge-warning'>"+bf_status+"</span></h3>");
   
                }else if(resultbf > 33){
                    bf_status = "Overweight"; 
                    $("#bf_status").html("<h3><span class='badge badge-danger'>"+bf_status+"</span></h3>");
                    
                }
            <?php } ?>
            
            $('input[name="bfValue"]').val(resultbf);
            $("#resultbf").html("<h1>"+resultbf+"</h1>");

         

        });

    });

     // save bmi
     function saveBMI(){

        $('#bmi').validate({
            rules: {
                weight: {
                    required: true,
                    number: true
                },
                height: {
                    required: true,
                    number: true
                },
                bmiValue: {
                    required: true,
                    number: true
                }
            },
            messages: {
                weight: {
                    required: "Please enter weight"
                },
                height: {
                    required: "Please enter height"
                },
                bmiValue: {
                    required: "Please calculate BMI before save"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: '../../../controller/memberController.php?status=BMI',
                    data: $('form').serialize(),
                    cache: false,
                    success: function (returnJSON) {
                        try {
                            var JSON = jQuery.parseJSON(returnJSON);
                            if (JSON.Result) {
                                showStatusMessage('Success','Successfully saved.','success');
                            } else {
                                showStatusMessage('Warning','Calculate BMI before saving.','warning');
                            }
                        } catch (e) {
                            showStatusMessage('Danger','Unknown error occured.','danger');
                        }
                    },
                    error: function () {
                        showStatusMessage('Danger','Unknown error occured.','danger');
                    }
                });
                return false;
            },
    });
    } 

    function saveBodyFat(){

        $('#bfrm').validate({
            rules: {
                chest: {
                    required: true,
                    number: true
                },
                axila: {
                    required: true,
                    number: true
                },
                tricep: {
                    required: true,
                    number: true
                },
                subscapular: {
                    required: true,
                    number: true
                },
                abdominal: {
                    required: true,
                    number: true
                },
                suprailiac: {
                    required: true,
                    number: true
                },
                suprailiac: {
                    required: true,
                    number: true
                },
                thigh: {
                    required: true,
                    number: true
                },
                age: {
                    required: true,
                    number: true
                },
                bfValue: {
                    required: true,
                    number: true
                }
            },
            messages: {
                chest: {
                    required: "Please enter chest"
                },
                axila: {
                    required: "Please enter axila"
                },
                axila: {
                    required: "Please enter axila"
                },
                tricep: {
                    required: "Please enter tricep"
                },
                subscapular: {
                    required: "Please enter subscapular"
                },
                abdominal: {
                    required: "Please enter abdominal"
                },
                suprailiac: {
                    required: "Please enter suprailiac"
                },
                thigh: {
                    required: "Please enter thigh"
                },
                age: {
                    required: "Please enter age"
                },
                bmiValue: {
                    required: "Please calculate body fat before save"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: '../../../controller/memberController.php?status=BF',
                    data: $('form').serialize(),
                    cache: false,
                    success: function (returnJSON) {
                        try {
                            var JSON = jQuery.parseJSON(returnJSON);
                            if (JSON.Result) {
                                showStatusMessage('Success','Successfully saved.','success');
                            } else {
                                showStatusMessage('Warning','Calculate Body Fat before saving.','warning');
                            }
                        } catch (e) {
                            showStatusMessage('Danger','Unknown error occured.','danger');
                        }
                    },
                    error: function () {
                        showStatusMessage('Danger','Unknown error occured.','danger');
                    }
                });
                return false;
            }
        });
    } 
    </script>