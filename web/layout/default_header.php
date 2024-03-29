<!DOCTYPE html>
<?php include_once '../../../config/dbconnection.php'; ?>
<?php include_once '../../../config/session.php'; ?>
<?php include_once '../../../config/global.php'; ?>
<?php include_once '../../../model/subscription.php'; ?>
<?php
    // Get User Details from session
    $user=$_SESSION['user']; 
 
    if(!$user)
    {
        $msg = SESSION_TIMED_OUT;
        $msg = base64_encode($msg);
        header("Location:../index/login.php?msg=$msg");
        exit;
    }

?>
<html>
    <head>
        <title><?php echo SYSTEM_BUSINESS_NAME;?></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
        <!-- Including Google font -->
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../../public/css/layout.css"/>
        <link rel="stylesheet" href="../../../public/css/style.css"/>
        <!-- Including fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
        <link href="../../../public/plugin/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../../../public/plugin/jquery-ui/jquery-ui.css">
        <script src="../../../public/plugin/jquery/jquery-3.4.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>