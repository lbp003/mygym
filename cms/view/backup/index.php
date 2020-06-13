<?php include '../../layout/header.php'; ?>
<?php include '../../../model/member.php'; ?>
<?php 
$allMember = Member::displayAllMember();
// $row = $allMember->fetch_assoc();
// print_r($row); exit;
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Backup</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div>
                    <a class="btn btn-success btn-lg" href="../../../controller/backupController.php?status=Backup">Database Backup Download</a>
                </div>
            </div>
        </div>
    </div><br />
<?php include '../../layout/footer.php';?>