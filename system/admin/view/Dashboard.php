<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ----> 
<body onload="startTime()">
        <!---navbar starting ---------->
        <?php include '../common/navBar.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="#" class="active">Dashboard</a></li>
                    </ol>
                </div>
        </div>
        <!--- breadcrumb ending--------->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                <!----Admin side nav starting------>
            <?php include '../common/AdminSideNav.php'; ?>
                <!----Admin side nav ending------>
                </div>
                <div class="col-md-9 dashMod">
                    <div id="msg">
                        <p class="alert-danger" style="font-size: 16px; align: center">
                        <?php
                            if(isset($_REQUEST['msg'])){
                                echo base64_decode($_REQUEST['msg']);
                            }?>
                        </p>
                    </div>
                    <div>
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Dashboard</b></h1>
                    </div><hr />
                                <?php 
                                    while($uModule=$resultm->fetch_assoc()){
                                ?>
                    <section>
                        <div class="col-md-3">
                            
                            <div class="thumbnail">
                                <div style="text-align: center">
                                    <i class="fa fa-5x fa-<?php echo $uModule['module_image'];?>" aria-hidden="true"></i>
                                </div><hr />
                                <a href="<?php echo $uModule['module_name'];?>.php" class="btn btn-lg btn-block btn-info"><?php echo ucfirst($uModule['module_name']);?></a>
                              
                            </div>
                           
                        </div>
                    </section>
                         <?php } ?>
                </div>           
            </div>
        </div>
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>