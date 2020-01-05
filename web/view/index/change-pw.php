<!--- header start ---->
<?php include_once '../../layout/default_header.php'; ?>
<!--- header end ----> 
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/default_navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Change Password</a></li>
    </ol>
    </nav>
    <!-- module container -->
    <div class="container-fluid">
            <div class="row justify-content-center" style="height: 100%;">
                <div class="col-4 pt-5">
                    <form method="post" name="changePw" action="../../../controller/memberController.php?status=changePw" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Current Password" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="newPwd" class="form-control" id="newPwd" pattern=".{6,}" placeholder="New Password" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="conNewPwd" class="form-control" id="conNewPwd" pattern=".{6,}" placeholder="Confirm New Password" required />
                            </div>
                        </div>
                        <div>
                            <p class="font-weight-normal text-danger">
                            <?php
                                if(!empty($_REQUEST['msg_pw'])){
                                    echo base64_decode($_REQUEST['msg_pw']);
                                }
                            ?>
                            </p>
                        </div> 
                        <div class="float-right">
                            <input type="submit" class="btn btn-dark" value="Submit" />
                        </div>    
                    </form>
                </div>
            </div>
        </div><br />
    <?php include_once '../../layout/default_footer.php';?>