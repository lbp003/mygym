<?php include '../common/myPlanHeader.php';?><!---- include header ------>
<?php include_once '../admin/model/packageModel.php';?><!---- include package model ------->
<?php 
    $objpa = new package();
    $result = $objpa->displayAllPackage();
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
            <li><a href="myMembership.php">myMembership</a></li>
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
                <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>myMembership</b></h1>
                <br />
            </div>
            </div>
        <section style="background-color:rgb(250,250,250);">
            <?php while($pacRow = $result->fetch_assoc()){?>
                <?php
                    $image ="../admin/images/package_image/".$pacRow['package_image']
                ?>
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3><?php echo $pacRow['package_name'] ?></h3>
                        </div>
                        <div class="panel-body">
                            <img src="<?php echo $image?>" class="img img-responsive img-thumbnail center-block" width="75%" height="25%" alt="package image" /><hr />
                                <h4 style="float: left;">Duration : <?php echo $pacRow['duration']?> months</h4>
                                <h4 style="float: right;">Price : <?php echo $pacRow['price']?>.00</h4>
                        </div>
                        <div class="panel-footer">
                            <p align="left"><?php echo $pacRow['package_description']?>
                                <br/>
                                <a class="btn btn-danger" href="#" style="float: right; padding-right: 10px;" >Select</a>
                            </p>
                            <br />
                        </div>
                    </div>
                </div>    
            <?php } ?>           
        </section>
        </div>
    </div>
</div>
<?php include '../common/myPlanFooter.php';?>