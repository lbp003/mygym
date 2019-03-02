<?php include_once '../common/Session.php'; ?>
<?php include_once '../common/dbconnection.php'; ?>
<?php include_once '../common/CommonSql.php'; ?>

<?php

$StaffDetails=$_SESSION['userDetails'];
$role_id=$StaffDetails['role_id'];
$staff_id = $StaffDetails['staff_id'];

$obm = new CommonFun();
$resultm=$obm->viewRoleModule($role_id);
//echo $userDetails['gender'].$userDetails['dob'];
//print_r($resultm);
?>

<html>
    <head>
        <title>Z gym</title>
        <link type="text/css" rel="stylesheet" href="../bootstrap/bootstrap-3.3.7/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="../css/adlayout.css" />
        <link type="text/css" rel="stylesheet" href="../css/adStyle.css"/>
        <!--<link type="text/css" rel="stylesheet" href="../DataTables/datatables.min.css"/>-->
        <link type="text/css" rel="stylesheet" href="../DataTables/buttons.dataTables.min.css" />
        <link type="text/css" rel="stylesheet" href="../DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css"/>
        <link type="text/css" rel="stylesheet" href="../jquery/jquery-ui.min.css"/>
        <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" />-->
        <link type="text/css" rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet'>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
<!--        -- Bootstrap 4 Start---
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        -- Bootstrap 4 End-----
        -->
        
        <script type="text/javascript" src="../jquery/jquery-3.3.1.min.js"></script>
        <!--<script type="text/javascript" src="../jquery/jquery-3.3.1.min.js"></script>-->
        <script type="text/javascript" src="../jquery/jquery-ui.min.js"></script>
        
        <script type="text/javascript" src="../bootstrap/bootstrap-3.3.7/js/bootstrap.min.js" ></script>
        <script type="text/javascript" src="../js/bootstrap3-typeahead.min.js"></script>
        <script type="text/javascript" src="../js/bootbox.min.js"></script>
        
        
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