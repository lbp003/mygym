<!--- header  ---->
<?php
include '../../layout/header.php'; ?>
<?php 
    $pacData = $_SESSION['pacData'];
    // echo json_encode($pacData); exit;
    $subID = $_REQUEST['subID'];
    $memID = $_REQUEST['memID'];
    $pacID = $_REQUEST['pacID'];

    $subscriptionID = base64_decode($subID);
    $memberID = base64_decode($memID);
    $packageID = base64_decode($pacID);
    // var_dump($memberID); exit;
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
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Select Package</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="updatePackage" name="updatePackage" action="../../../controller/subscriptionController.php?status=Reactivate" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="package">Package</label>
                        <select id="package" name="package" class="form-control">
                            <option value="">Choose...</option>
                            <?php foreach($pacData as $key => $val){?>
                            <option value="<?php echo $key;?>" <?php if($packageID == $key) echo "selected"; ?>><?php echo $val;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="hidden" id="subscription_id" name="subscription_id" value="<?php echo $subscriptionID;?>">
                        <input type="hidden" id="member_id" name="member_id" value="<?php echo $memberID;?>">
                        <button type="submit" class="btn btn-primary mb-2 float-right">Next</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
<!--- footer  ---->
<?php include '../../layout/footer.php';?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#updatePackage').validate({
            rules: {
                package: "required"
            },
            messages: {             
                package: {
                    required: "Please select a package"
                }
            }
        });
    });
</script>