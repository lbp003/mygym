<?php include '../common/myPlanHeader.php';?><!---- include header ------>
<body onload="startTime()">
<?php
   // var_dump($_SESSION['userDetails']);
?>
        <!----- side navbar startng ------> 
        <?php include '../common/myPlanNav.php';?>
        <!------side navbar ending ---->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div id="msg">
                        <p class="alert-danger" style="font-size: 16px; align: center">
                        <?php
                            if(isset($_REQUEST['msg'])){
                                echo base64_decode($_REQUEST['msg']);
                            }?>
                        </p>
                    </div>
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
            <li><a href="myPlan.php">profile</a></li>
        </ol>
    </div>
</div>
<div class="container-fluid">
    <div class="row"> 
        <div class="col-md-3">
            <?php include '../common/myPlanSideNav.php';?><!------ myplan side nav -------->
        </div>       
        <div class="col-md-9">
            <div class="row">
            <div class="col-md-12">
                <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Member Profile</b></h1>
                <br />
            </div>
            </div>
        <section>
            <div class="row" style="background-color:rgb(250,250,250);">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-4">
                    <h2>Name</h2>
                    <h2>Email</h2>
                </div>
                <div class="col-md-4">
                    <h2><?php  
                            if($memberDetails['gender']=="male"){
                                echo "<p>:Mr.".ucfirst($memberDetails['member_fname'])." ".ucfirst($memberDetails['member_lname'])."</p>";
                            }else{
                                echo "<p>Mrs.</p>".ucfirst($memberDetails['member_fname'])." ".ucfirst($memberDetails['member_lname']);
                             }
                        ?>
                    </h2>
                    <h2><?php  
                            echo $memberDetails['member_email'];
                        ?>
                    </h2>
                </div>
                <br>
                <div><a href="#"><input type="button" value="View Profile" name="view" class="btn-lg btn-danger" style="float: right" /></a></div>
                <div class="col-md-2">&nbsp;</div>
            </div> 
        </section>
        </div>
    </div>
</div>
<?php include '../common/myPlanFooter.php';?>