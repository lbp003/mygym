<?php include '../common/Session.php'; ?>
<?php include '../common/dbconnection.php'; ?>
<?php include '../admin/common/CommonSql.php'; ?>

<html>
    <head>
        <title>my Gym</title>
        <link type="text/css" rel="stylesheet" href="../admin/bootstrap/bootstrap-3.3.7/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="../admin/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet'>
        <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">-->
        <link type="text/css" href="../admin/DataTables/datatables.min.css"/>
        <link type="text/css" rel="stylesheet" href="../css/layout.css" />
        <link type="text/css" rel="stylesheet" href="../css/style.css" />
        <link type="text/css" rel="stylesheet" href="../admin/jquery/jquery-ui.min.css"/>
        <link type="text/css" rel="stylesheet" href="../assets/css/style.css"/>
        <link type="text/css" rel="stylesheet" href="../assets/css/reset.css"/>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <script type="text/javascript" src="../admin/DataTables/datatables.min.js"></script>
        <script type="text/javascript" src="../admin/bootstrap/bootstrap-3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../admin/jquery/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../admin/js/bootstrap3-typeahead.min.js"></script>
        <style type="text/css">
            .modal-dialog {width:600px;}
            .thumbnail {margin-bottom:6px;}
        </style>
        
    </head>
    <body>
        <!------top bar starting----->
        <div class="container-fluid" id="top-bar">
            <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 top-bar-r center-block">
                <i class="fa fa-2x fa-user-o" aria-hidden="true"></i><a href="../view/login.php" target="_blank"> My login</a>&nbsp;&nbsp; |&nbsp;&nbsp;
                <i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i><a href="../view/registerEmail.php" target="_blank"> Register</a> &nbsp;&nbsp;|&nbsp;&nbsp;
                <i class="fa fa-2x fa-envelope-o" aria-hidden="true"></i><a href="../view/contact.php"> Contact Us</a>
                
            </div>
            <div class="col-md-4 col-lg-4 col-sm-6 hidden-xs top-bar-l">
                <a href="#"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;
                <a href="#"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;
                <a href="#"><i class="fa fa-youtube-square fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;
                 <a href="#"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
            </div>
            <div class="col-md-4 col-lg-4 hidden-sm hidden-xs">&nbsp;</div>
        </div>
        <!------top bar ending----->
        <!--- banner starting---->
<!--        <div class="container-fluid">
            <div class="row" style="background-color: #cccccc">
                <div class="col-md-6">
                    <img class="img-responsive center-block" alt="Z gym" src="../images/z-gym-logo.png" height="auto" width="150px"/>
                </div>
                <div class="6">&nbsp;</div>
            </div>  
        </div>       -->
        <!--- banner ending -------->