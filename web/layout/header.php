<?php include_once '../../config/session.php'; ?>
<?php include_once '../../config/dbconnection.php'; ?>

<html>
    <head>
        <title>my Gym</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <!-- <link rel="stylesheet" href="../../public/css/style.css"/> -->
        <link rel="stylesheet" href="../../public/css/layout.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            /* Make the image fully responsive */
            .carousel-inner img {
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body>
        <!------top bar starting----->
        <div class="container-fluid top-bar">
            <div class="offset-md-10">
                <div>
                    <i class="far fa-user" aria-hidden="true"></i><a href="../view/login.php" target="_blank"> My login</a>&nbsp;&nbsp; |&nbsp;&nbsp;
                    <i class="far fa-envelope" aria-hidden="true"></i><a href="../view/contact.php"> Contact Us</a>               
                </div>
            </div>
        </div>
        <!------top bar ending----->