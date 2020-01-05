<?php include_once '../../../config/dbconnection.php'; ?>
<?php include_once '../../../config/session.php'; ?>
<?php include_once '../../../config/global.php'; ?>
<?php include_once '../../../model/role.php'; ?>
<?php include_once '../../../model/class.php'; ?>
<?php include_once '../../../model/classSession.php'; ?>
<?php include_once '../../../model/event.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo SYSTEM_BUSINESS_NAME;?> &mdash; Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
    <link rel="stylesheet" href="../../../public/theme/fonts/icomoon/style.css">

    <link rel="stylesheet" href="../../../public/theme/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/theme/css/magnific-popup.css">
    <link rel="stylesheet" href="../../../public/theme/css/jquery-ui.css">
    <link rel="stylesheet" href="../../../public/theme/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../../public/theme/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../../../public/theme/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../../../public/theme/css/animate.css">
    
    
    <link rel="stylesheet" href="../../../public/theme/fonts/flaticon/font/flaticon.css">
  
    <link rel="stylesheet" href="../../../public/theme/css/aos.css">

    <link rel="stylesheet" href="../../../public/theme/css/style.css">
    <?php
      $allClass = Programs::getAllActiveClass();
      $allSessionMon = Session::getActiveClassSessionMon();
      $allSessionTue = Session::getActiveClassSessionTue();
      $allSessionWed = Session::getActiveClassSessionWed();
      $allSessionThu = Session::getActiveClassSessionThu();
      $allSessionFri = Session::getActiveClassSessionFri();
      $allSessionSat = Session::getActiveClassSessionSat();
      $allSessionSun = Session::getActiveClassSessionSun();
      $allEvents = Event::displayAllActiveEvent();
    ?>
    
  </head>