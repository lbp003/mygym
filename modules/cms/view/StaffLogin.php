<?php include '../common/Session.php';?>
<!------Header starting ------>
<html>
    <head>
        <title>Dashboard</title>
        <link type="text/css" rel="stylesheet" href="../bootstrap/bootstrap-3.3.7/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="../css/adlayout.css" />
        <link type="text/css" rel="stylesheet" href="../css/adstyle.css" />
        <link type="text/css" rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet'>
    </head>
    <body>
        <!---navbar starting ---------->
        <nav class="navbar navbar-inverse">
            <div class="container">          
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                     </button>
                    <h3 style="font-size: 24px; color: white; margin-top: 10px">Z Gym</h3>
                    
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right" style="font-size: 24px; color: white; margin-top: 10px">
                        <li>Staff Login</li>
                            </ul>
                    </div>
        
            </div>
        </nav>
        <!---navbar end----->
<!---- header ending------>
<div class="container-fluid">
    <div class="row">
    <div class="log-bg col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="log-text">
            <div class="col-md-4">&nbsp;</div>
                <div class="col-md-4">
                    <p>WELCOME</p>
                    <form method="post" name="slogin" action="../controller/logincontroller.php">
                         <?php 
                            $_SESSION['user_type']="staff";
                            
                        ?>
                        <div id="msg" class="alert-danger">
                            <p style="font-size: 16px">
                            <?php
                                if(isset($_REQUEST['msg'])){
                                    echo base64_decode($_REQUEST['msg']);
                            
                                }
                            ?>
                            </p>
                        </div>  
                        <div class="form-group">
                            <label for="uname" class="sr-only">User Name :</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="uname" class="form-control" id="uname" placeholder="User Name" />
                            </div>
                        </div>
                        <div class="form-group">
                           <label for="password" class="sr-only">Password :</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" name="pass" class="form-control" id="pass" placeholder="Password" />
                            </div>
                        </div>
                        <div>
                          <!--  <button type="submit" class="btn btn-danger" style="float: right"><a href="">Sign In</a></button> -->
                            <button type="submit" class="btn btn-danger" style="float: right">Sign in</button>
                        </div>    
                    </form>
                
                </div>
            <div class="col-md-4">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
<!-----footer starting -------->
        <footer>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 adfooter">
                        <hr />
                        <small>Developed by</small><p>LBP Creations &COPY; 2017</p>
                    </div>
                </div>
            </div>        
</footer>
        <script type="text/javascript" src="../bootstrap/bootstrap-3.3.7/js/bootstrap.min.js" />
        <script type="text/javascript" src="../js/jquery-3.1.1.min.js" />    
    </body>
</html>
<!--------footer ending --------->

