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
            <li><a href="#">myDATA</a></li>
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
                <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>myDATA</b></h1>
                <br />
            </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);">Store data & track your progress</h1>
                    <small align="center" style="font-family: monospace;color: #ff0000;background-color:rgba(70,70,70,0.5);">*Enter Metric Units</small>
                    <small align="center" style="font-family: monospace;color: #ff0000;background-color:rgba(70,70,70,0.5); float: right">*Your personal data won't share with outside of the gym</small>
                    <hr>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <?php if(isset($_REQUEST['msg'])){ 
                                $msg= base64_decode($_REQUEST['msg']);
                            ?>
                            <span id="error_msg" class="alert alert-danger"><?php echo $msg; ?></span>
                                
                            <?php   } ?>

                            <div id="error_msg" style="text-align: center" >&nbsp;</div>
                            <div>&nbsp;</div>
                        </div>
                    </div>
                </div>
                <form method="post" action="../admin/controller/myPlanController.php?status=Bodyfat&member_id=<?php echo $userDetails['member_id']?>&dob=<?php echo $userDetails['dob']?>&gender=<?php echo $userDetails['gender']?>" enctype="multipart/form-data">
                    <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 align="center" style="font-family: monospace; color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Jackson/Pollock 7-Site Caliper Method<br>-Body Fat</b></h1>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <img class="img-responsive img-thumbnail" src="../images/male-7site-Jackson-Pollock.png" height="auto" width="auto" alt="male"/>
                            </div>
                            <div class="col-md-6">
                                <img class="img-responsive img-thumbnail" src="../images/female-7site-Jackson-Pollock.png" height="auto" width="auto" alt="male"/>
                            </div>
                        </div><hr />                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Axilla">Axilla skinfold</label>
                                <div class="input-group">
                                <input type="text" name="Axilla" id="Axilla" class="form-control" placeholder="74.5" aria-describedby="weight" data-validation="number" data-validation-allowing="float">
                                <span class="input-group-addon" >mm</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Chest">Chest skinfold</label>
                                <div class="input-group">
                                <input type="text" name="Chest" id="Chest" class="form-control" placeholder="74.5" aria-describedby="weight">
                                <span class="input-group-addon" >mm</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Abdominal">Abdominal skinfold</label>
                                <div class="input-group">
                                <input type="text" name="Abdominal" id="Abdominal" class="form-control" placeholder="74.5" aria-describedby="weight">
                                <span class="input-group-addon">mm</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Subscapular">Subscapular skinfold</label>
                                <div class="input-group">
                                <input type="text" name="Subscapular" id="Subscapular" class="form-control" placeholder="74.5" aria-describedby="weight">
                                <span class="input-group-addon">mm</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Suprailiac">Suprailiac skinfold</label>
                                <div class="input-group">
                                <input type="text" name="Suprailiac" id="Suprailiac" class="form-control" placeholder="74.5" aria-describedby="weight">
                                <span class="input-group-addon" >mm</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Tricep">Tricep skinfold</label>
                                <div class="input-group">
                                <input type="text" name="Tricep" id="Tricep" class="form-control" placeholder="74.5" aria-describedby="weight">
                                <span class="input-group-addon">mm</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Thigh">Thigh skinfold</label>
                                <div class="input-group">
                                <input type="text" name="Thigh" id="Thigh" class="form-control" placeholder="74.5" aria-describedby="weight">
                                <span class="input-group-addon">mm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 well well-sm" style="text-align: center;padding-bottom: 0px;background-color: rgb(39, 92, 160)">
                            <?php if(isset($_REQUEST['stat'])){ 
                                $stat= base64_decode($_REQUEST['stat']);
                            ?>
                            <span style="font-size: 55px;color: #ffffff;font-weight: bold"><?php echo $stat; ?></span>
                                
                            <?php   } ?>

                            <div id="error_msg" style="text-align: center" >&nbsp;</div>
                            <div>&nbsp;</div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <button class="btn btn-lg btn-danger btn-block" name="reset" type="reset" value="rest">Reset</button>
                                <button class="btn btn-lg btn-success btn-block" name="submit" type="submit" value="Submit">Save</button>
                            </div>
                            <div class="col-md-4"></div>
                    </div>
                    </div>
            </form>
    </div><hr />
    <div class="row">
        <div class="col-md-12">
            <h2 style="font-size: 40px; font-family: monospace; color: #ffff00;background-color:rgba(70,70,70,0.5);">Percentage body fat table</h2>
        </div>
    <div class="col-md-12">
        <table class="table table-responsive table-striped">
            <thead>
                <th></th>
                <th>% BF Males</th>
                <th>% BF Females</th>
            </thead>
            <tbody>
                <tr style="background-color: rgb(255, 221, 187)">
                    <th>Lean</th>
                   <td>< 12</td>
                   <td>< 17</td>
                </tr>
                <tr style="background-color: rgb(204, 255, 204)">
                    <th>Acceptable</th>
                   <td>12 - 21</td>
                   <td>17 - 28</td>
                </tr>
                <tr style="background-color: rgb(255, 221, 187)">
                    <th>Moderately Overweight</th>
                   <td>21 - 26</td>
                   <td>28 - 33</td>
                </tr>
                <tr style="background-color: rgb(255, 170, 170)">
                    <th>Overweight</th>
                   <td>> 26</td>
                   <td>> 33</td>
                </tr>
            
            </tbody>
        </table>
    </div>
</div>
        </div>
    </div>
</div>
<?php include '../common/myPlanFooter.php';?>
        
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
