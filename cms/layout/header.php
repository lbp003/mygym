<?php include_once '../../config/session.php'; ?>
<?php include_once '../../model/role.php'; ?>
<?php
// Get User Details from session
$auth = new Role;
$user=$_SESSION['user'];
$staff_type = $_SESSION['staff_type'];

if(!$auth->checkPermissions([]))
    {
        echo json_encode(['Result'=>false,'Type'=>'ERROR','Message'=>UNAUTHORIZED_ACCESS]);
        exit;
    }

?>

<html>
    <head>
        <title>CMS</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
        <link rel="stylesheet" href="../../public/css/layout.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        
    </head>