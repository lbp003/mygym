<?php include_once '../common/header.php'; ?>
<?php include_once '../common/navBar.php';?>
<?php include_once '../admin/common/Session.php'; ?>

<div class="container-fluid">
    <div class="row">
    <div class="log-bg col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="log-text">
            <div class="col-md-4">&nbsp;</div>
                <div class="col-md-4">
                    <p>WELCOME</p>
                    <div class="row">
                        <div id="msg">
                            <small style="font-size: 14px; color: red;">
                                <?php
                                if(isset($_REQUEST['msg'])){
                                    echo base64_decode($_REQUEST['msg']);
                                    }
                                ?>
                            </small>
                        </div> 
                    </div>
                    <form action="../admin/controller/logincontroller.php" method="post">
                        <?php 
                            $_SESSION['user_type']="member";
                            
                        ?>
                        <div class="form-group">
                            <label for="uname" class="sr-only">Email :</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: #333333"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="uname" placeholder="User Name" name="uname" />
                            </div>
                        </div>
                        <div class="form-group">
                           <label for="password" class="sr-only">Password :</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: #333333"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" placeholder="Password" name="pass" />
                            </div>
                        </div>
                        <div>   <a type="submit" class="btn btn-danger" style="float: left" href="registerEmail.php">Register Now</a>
                                <!--<button type="submit" class="btn btn-danger" style="float: right">Sign In</button> --->
                                <input type="submit" class=" btn btn-danger" Value="Login" style="float: right" /> 
                        </div>
                    </form>
                    
                </div>
            <div class="col-md-4">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
<?php include_once '../common/footer.php'; ?>
