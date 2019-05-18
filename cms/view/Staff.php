<!--- header start ---->
<?php include '../layout/header.php'; ?>
<!--- header end ---->
<?php include '../../model/staff.php'; ?>
<?php 
$allstaff = Staff::displayAllStaff();
var_dump($allstaff);
?>
<body>
    <!---navbar starting ---------->
    <?php include '../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">Staff</li>
    </ol>
    </nav>
<?php include '../layout/footer.php';?>