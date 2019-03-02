<?php include '../common/Session.php'; ?>
<?php include '../common/dbconnection.php'; ?>
<?php include '../admin/model/loginModel.php';?>
<?php include '../admin/model/memberModel.php';?>
<?php 
$memberDetails=$_SESSION['userDetails'];
$role_id=$memberDetails['role_id'];
$member_id = $memberDetails['member_id'];
$obMem = new member();
?>
<html>
    <head>
        <title>myPlan</title>
        <link type="text/css" rel="stylesheet" href="../admin/bootstrap/bootstrap-3.3.7/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="../css/layout.css" />
        <link type="text/css" rel="stylesheet" href="../css/style.css"/>
        <link type="text/css" rel="stylesheet" href="../admin/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
        <link type="text/css" href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
        <link type="text/css" href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet'>
        <link type="text/css" href="../admin/DataTables/datatables.min.css" rel="stylesheet"/>
        <link type="text/css" href="../admin/jquery/jquery-ui.min.css" rel="stylesheet"/>
        <!--<link type="text/css" rel="stylesheet" href="../assets/css/styles.css"/>-->
        
        
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <script type="text/javascript" src="../admin/DataTables/datatables.min.js"></script>
        <script type="text/javascript" src="../admin/bootstrap/bootstrap-3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../admin/bootstrap/bootstrap-3.3.7/css/bootstrap-theme.min.css"></script>
        <script type="text/javascript" src="../admin/jquery/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../admin/js/bootstrap3-typeahead.min.js"></script>
        <script type="text/javascript" src="../admin/js/bootbox.min.js"></script>
        
       <!--- Script taken from W3C School ------->
        <script>
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('txt').innerHTML =
                h + ":" + m + ":" + s;
                var t = setTimeout(startTime, 500);
            }
            function checkTime(i) {
                if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                return i;
            }
        </script>
        <!--- Script ending ------->
    </head>