<?php include '../../layout/header.php'; ?>
<?php include_once '../../../model/subscription.php'; ?>
<?php 
    $subsData = $_SESSION['subscriptionData'];

    if($subsData['payment_status']==Subscription::PAID){
        $status="Paid";
    }elseif($subsData['payment_status']==Subscription::LATE){
        $status="Late";
    }else{
        $status="Pending";
    }
?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Subscription</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">View Subscription</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
                <form>
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="first_name">Member Name</label>
                        <input class="form-control" value="<?php echo $subsData['member_name']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="last_name">Package Name</label>
                        <input class="form-control" value="<?php echo $subsData['package_name']?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Subscription Start Date</label>
                        <input class="form-control" value="<?php echo date("Y-m-d", strtotime($subsData['start_date']));?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Subscription End Date</label>
                        <input class="form-control" value="<?php echo date("Y-m-d", strtotime($subsData['end_date']));?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Last Paid Date</label>
                        <input class="form-control" value="<?php echo date("Y-m-d", strtotime($subsData['last_paid_date']));?>" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Payment Status : </label>
                        <span style="font-size: 16px;" class="badge <?php if($subsData['payment_status']==Subscription::PAID){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>