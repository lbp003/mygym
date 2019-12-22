<!--- header start ---->
<?php include_once '../../layout/default_header.php'; ?>
<!--- header end ----> 
<?php 
    $memberID = $_SESSION['user']['member_id'];
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
            <div class="col-9 d-flex flex-row">
                <div class="col-4">
                    <h3>BMI</h3>
                    <p>Your BMI:</p>
                    <div id="result"></div>
                    <div id="bmi_status"></div>
                </div>
                <div class="col-6">
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
            </div>      
        </div>
    </div>
<?php include_once '../../layout/default_footer.php';?>
<!-- http://jsfiddle.net/wbMk7/10/  --> 
<script>
    $( document ).ready(function() {
    
        // Cache Event Elements
        var calculate = $('#calculate');
        var result = $('#result');

        // RENDER SELECTED UNIT
        calculate.on('click', function(e){
            e.preventDefault();
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
                
            }else if(result >= 18.5 && result <= 24.9){
                bmi_status = "Normal weight"; 
                $("#bmi_status").html("<h3><span class='badge badge-success'>"+bmi_status+"</span></h3>");
                
            }else if(result >= 25 && result <= 29.9){
                bmi_status = "Overweight"; 
                $("#bmi_status").html("<h3><span class='badge badge-warning'>"+bmi_status+"</span></h3>");
            }else if(result = 30 && result > 30){
                bmi_status = "Obesity"; 
                $("#bmi_status").html("<h3><span class='badge badge-danger'>"+bmi_status+"</span></h3>");
            }

        });

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
                    required: "Please enter phone"
                },
                height: {
                    required: "Please enter phone"
                },
                bmiValue: {
                    required: "Please calculate BMI before save"
                }
            }
        });

    });

     // admin count
     function saveBMI(){

        $('form').one('submit', function (e) {
            e.preventDefault();
 
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

        });
    } 
    </script>