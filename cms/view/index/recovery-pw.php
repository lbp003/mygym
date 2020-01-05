<?php include '../../../config/session.php';?>
<!------Header starting ------>
<html>
    <head>
        <title>CMS</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="../../../public/css/style.css" />
        <link type="text/css" rel="stylesheet" href="../../../public/css/layout.css" />
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

        <style>
            body, html {
                height: 100%;
            }

            .btn{
                background-color: #2cabe2;
            }
        </style>
         <?php

            if(!empty($_REQUEST['id'])){
                $id = $_REQUEST['id'];
            }else{
                header("Location:index.php");
                exit;  
            }
        ?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row justify-content-center" style="height: 100%;">
                <div class="col-4 pt-5">
                    <p class="text-center text-light text-dark">Please enter your new password.</p><hr />
                    <form method="post" name="forgetPw" action="../../../controller/userController.php?status=recverPwSt&staff_id=<?php echo $id?>" enctype="multipart/form-data">
                        <div class="form-group">
                        <label for="pwd" class="sr-only">Password:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="pwd" class="form-control" id="pwd" pattern=".{6,}" placeholder="password" required />
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="conPwd" class="sr-only">Confirm Password:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="conPwd" class="form-control" id="conPwd" pattern=".{6,}" placeholder="Confirm Password" required />
                            </div>
                        </div>
                        <div>
                            <p class="font-weight-normal text-danger">
                            <?php
                                if(!empty($_REQUEST['msg'])){
                                    echo base64_decode($_REQUEST['msg']);
                                }
                            ?>
                            </p>
                        </div> 
                        <div class="float-right">
                            <input type="submit" class="btn" value="Submit" />
                        </div>    
                    </form>
                    <div class="text-center">
                        <br />
                        <a href="index.php">Home</a>
                    </div>
                </div>
            </div>
        </div>
<!-----footer starting -------->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <hr />
                        <small>Developed by LBP &COPY; <?php echo date("Y"); ?> | All Rights Reserved</small>
                    </div>
                </div>
            </div>        
        </footer> 
    </body>
</html>
<!--------footer ending --------->

