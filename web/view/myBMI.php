<?php include_once '../common/myPlanHeader.php';?>
<?php
$userDetails=$_SESSION['userDetails'];
$role_id=$userDetails['role_id'];
?>
<body onload="startTime()">
        <!----- side navbar startng ------> 
        <?php include '../common/myPlanNav.php';?>
        <!------side navbar ending ---->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="myPlan-bg">
                            <h1 align="center" style="font-size: 60px;color: #ffff00;background-color:rgba(72,72,72,0.7);font-family: monospace"><b>myPlan</b></h1>
                    </div>
                </div>
            </div>
        </div>
<div class="container-fluid">
    <div class="row">
        <ol class="breadcrumb" style="background-color:#2f2f2f">
            <li><a href="myPlan.php">myPlan</a></li>
            <li><a href="#">myBMI</a></li>
        </ol>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../common/myPlanSideNav.php';?>
        </div> 
        <div class="col-md-9" style="padding-left: 20px; padding-right: 20px">
            <div class="row">
                <div class="col-md-12">
                    <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);">BMI Calculator</h1>
                    <small align="center" style="font-family: monospace;color: #990000;background-color:rgba(70,70,70,0.5);">*Enter Metric Units</small>
                    <small align="center" style="font-family: monospace;color: #990000;background-color:rgba(70,70,70,0.5); float: right">*Your personal data won't share with outside of the gym</small>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    <?php if(isset($_REQUEST['msg'])){ 
                        $msg= base64_decode($_REQUEST['msg']);
                    ?>
                    <span class="alert alert-danger"><?php echo $msg; ?></span>

                    <?php   } ?>                          
                </div>
                <div class="col-md-12">
                    <div id="error_msg" style="text-align: center" >&nbsp;</div>
                    <div>&nbsp;</div>
                </div>
                </div>
<!----------BMI Calculator from github------------->
<div class="row">
    <div class="col-md-2">&nbsp;</div>
    <div class="col-md-8">
      <div id="BMI_Calculator">
          <form class="bmicalc-form" data-toggle="validator" role="form" method="post" action="../admin/controller/myPlanController.php?member_id=<?php echo $userDetails['member_id']?>&status=BMI" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-body" style="background-color: #cccccc">
                        <div class="form-group">
                            <label for="gender" class="control-label">Gender:</label>
                            <div id="gender">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="Male" required> Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="Female" required> Female
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="age" class="control-label">Age:</label>
                            <select id="age" class="form-control" required>
                                <option value="">Age (years)</option>
                                <option value="19 - 24">19 - 24</option>
                                <option value="25 - 34">25 - 34</option>
                                <option value="35 - 44">35 - 44</option>
                                <option value="45 - 54">45 - 54</option>
                                <option value="55 - 64">55 - 64</option>
                                <option value="&gt; 64">&gt; 64</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="weight" class="control-label">Weight:</label>
                            <input name="weight" id="weight" type="text" class="form-control" placeholder="weight (kg)" required>
                        </div>
                        <div class="form-group">
                            <label for="height" class="control-label">Height:</label>
                            <input name="height" id="height" type="text" class="form-control" placeholder="height (cm)" required>
                        </div>
                        <button type="submit" class="btn btn-lg btn-block btn-success" style="background-color: rgb(49, 176, 213)">Calculate</button>
                        <button type="reset" class="btn btn-lg btn-block btn-danger">Reset</button>
                    </div>
                    <div class="panel-footer text-center" style="background-color:#cccccc">
                        <label class="bmicalc-result-label text-info">BMI Score</label>
                        <div class="well well-sm bmicalc-result mb-5">0.00</div>
                        <label class="bmicalc-description-label text-info">Interpretation</label>
                        <div class="well well-sm bmicalc-description mb-5">&nbsp;</div>
                        <small class="text-center">
                            <a href="../images/bmi_tbl.pdf" target="_blank" id="BMI_Tables_FancyBox" data-fancybox-type="inline" style="color: #222222" class="btn btn-link">View BMI Tables</a>
                        </small>
                    </div>
                </div>
            </form>
        </div>  
    </div>
    <div class="col-md-2">&nbsp;</div>
</div>        
<!----------BMI Calculator from github------------->
<div class="row">
    <div class="col-md-12">
        <table class="table table-responsive table-striped">
            <thead>
                <th>BMI</th>
                <th>Weight Status</th>
            </thead>
            <tbody>
                <tr>
                   <td>Below 18.5</td>
                   <td style="background-color: rgb(255, 221, 187)">Underweight</td>
                </tr>
                <tr>
                   <td>18.5-24.9</td>
                   <td style="background-color: rgb(204, 255, 204)">Healthy</td>
                </tr>
                <tr>
                   <td>25.0-29.9</td>
                   <td style="background-color: rgb(255, 221, 187)">Overweight</td>
                </tr>
                <tr>
                   <td>30.0 and above</td>
                   <td style="background-color: rgb(255, 170, 170)">Obese</td>
                </tr>
            
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-warning">
            <div class="panel-heading" style="font-weight: bold; font-size: large;background-color:rgb(255, 221, 187)">BMI of less than 18.5</div>
        <div class="panel-body">A BMI of less than 18.5 indicates that you are underweight, so you may need to put on some weight. You are recommended to ask your doctor or a dietitian for advice.</div>       
        </div>
        <div class="panel panel-success">
        <div class="panel-heading" style="font-weight: bold; font-size: large;background-color:rgb(204, 255, 204)">BMI of 18.5-24.9</div>
        <div class="panel-body">A BMI of 18.5-24.9 indicates that you are at a healthy weight for your height. By maintaining a healthy weight, you lower your risk of developing serious health problems.</div>       
        </div>
        <div class="panel panel-warning">
        <div class="panel-heading" style="font-weight: bold; font-size: large;background-color:rgb(255, 221, 187)">BMI of 25-29.9</div>
        <div class="panel-body">A BMI of 25-29.9 indicates that you are slightly overweight. You may be advised to lose some weight for health reasons. You are recommended to talk to your doctor or a dietitian for advice.</div>       
        </div>
        <div class="panel panel-danger">
        <div class="panel-heading" style="font-weight: bold; font-size: large;background-color:rgb(255, 170, 170)">BMI of over 30</div>
        <div class="panel-body">A BMI of over 30 indicates that you are heavily overweight. Your health may be at risk if you do not lose weight. You are recommended to talk to your doctor or a dietitian for advice.</div>       
        </div>
    </div>
</div>
    </div>
    </div>
</div>
<?php include '../common/myPlanFooter.php'?>
        <script type="text/javascript">
            $(document).ready(function(){
               $('form').submit(function(){
                  
                  var Height=$('#Height').val();
                  var Weight=$('#Weight').val();
                  var Axilla=$('#Axilla').val();
                  var Chest=$('#Chest').val();
                  var Abdominal=$('#Abdominal').val();
                  var Subscapular=$('#Subscapular').val();
                  var Suprailiac=$('#Suprailiac').val();
                  var Tricep=$('#Tricep').val();
                  var Thigh=$('#Thigh').val();
                  
                  
                  
                  if(Height==""){
                    $('#error_msg').text("Height is empty");//To display error
                    $('#error_msg').addClass('alert-danger');
                    $('#Height').focus();
                    return false; //
                    }
                    if(Weight==""){
                    $('#error_msg').text("Weight is empty");//To display error
                    $('#error_msg').addClass('alert-danger');
                    $('#Weight').focus();
                    return false; //
                    }
                    if(Axilla==""){
                    $('#error_msg').text("Axilla is empty");//To display error
                    $('#error_msg').addClass('alert-danger');
                    $('#Axilla').focus();
                    return false; //
                    }
                    if(Chest==""){
                    $('#error_msg').text("Chest is empty");//To display error
                    $('#error_msg').addClass('alert-danger');
                    $('#Chest').focus();
                    return false; //
                    }
                    if(Abdominal==""){
                    $('#error_msg').text("Abdominal is empty");//To display error
                    $('#error_msg').addClass('alert-danger');
                    $('#Abdominal').focus();
                    return false; //
                    }
                    if(Subscapular==""){
                    $('#error_msg').text("Subscapular is empty");//To display error
                    $('#error_msg').addClass('alert-danger');
                    $('#Subscapular').focus();
                    return false; //
                    }
                    if(Suprailiac==""){
                    $('#error_msg').text("Suprailiac is empty");//To display error
                    $('#error_msg').addClass('alert-danger');
                    $('#Suprailiac').focus();
                    return false; //
                    }
                    if(Tricep==""){
                    $('#error_msg').text("Tricep is empty");//To display error
                    $('#error_msg').addClass('alert-danger');
                    $('#Tricep').focus();
                    return false; //
                    }
                    if(Thigh==""){
                    $('#error_msg').text("Thigh is empty");//To display error
                    $('#error_msg').addClass('alert-danger');
                    $('#Thigh').focus();
                    return false; //
                    }
                  
                  
               }); 
            });
        </script>
