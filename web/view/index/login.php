<?php include '../../../config/session.php';?>
<?php include '../../../config/global.php';?>

<!------Header starting ------>
<html>
    <head>
        <title><?php echo SYSTEM_BUSINESS_NAME;?></title>
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

            .bg { 
                /* The image used */
                background-image: url("../../../public/image/login-bg.jpg");

                /* Full height */
                height: 100%; 

                /* Center and scale the image nicely */
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }

            .btn{
                background-color: #2cabe2;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid bg">
            <div class="row justify-content-center" style="height: 100%;">
                <div class="col-4 pt-5">
                    <h1 class="text-center text-light">WELCOME</h1><hr />
                    <form method="post" name="slogin" action="../../../controller/loginController.php">
                        <?php $_SESSION['user_type']="member"; ?> 
                        <div class="form-group">
                            <label for="uname" class="sr-only">Email :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-user"></i></span>
                                </div>
                                <input type="text" name="email" class="form-control" id="email" placeholder="Email" />
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="password" class="sr-only">Password :</label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" />
                            </div>
                        </div>
                        <div>
                            <p class="font-weight-normal text-danger bg-dark">
                            <?php
                                if(isset($_REQUEST['msg'])){
                                    echo base64_decode($_REQUEST['msg']);
                                }
                            ?>
                            </p>
                        </div> 
                        <div class="float-right">
                            <input type="submit" class="btn" value="Login" />
                        </div>    
                    </form><br /><br />
                    <div class="col-12 text-center">
                        <a href="../../../"><i class="fas fa-home fa-2x" style="color: white"></i></a>
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
                        <small>Developed by LBP Creations &COPY; <?php echo date("Y"); ?> | All Rights Reserved</small>
                    </div>
                </div>
            </div>        
        </footer>
        <script type="text/javascript">
        $( document ).ready(function() {
            $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            })

            //notify messages
            <?php 
            if(isset($_REQUEST['msg'])){
                $msg = $_REQUEST['msg'];
                $msgAr = json_decode($msg, true); ?>
                var title = '<?php echo $msgAr["title"];?>';
                var message = '<?php echo $msgAr["message"];?>';
                var type = '<?php echo $msgAr["type"];?>';
            
                $.notify({
                    title: title,
                    message: message
                },{
                    type: type,
                    delay: 3000,
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    animate:{
                        enter: "animated fadeInUp",
                        exit: "animated fadeOutDown"
                    }
                });
            <?php } ?>
        });
    </script>  
    </body>
</html>
<!--------footer ending --------->

