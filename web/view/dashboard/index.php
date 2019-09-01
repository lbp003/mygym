<!--- header start ---->
<?php include_once '../../layout/default_header.php'; ?>
<?php 
    if(empty($user['image'])){
        $path = "../../../".PATH_IMAGE."user.png"; 
    }else{ 
        $path = "../../../".PATH_IMAGE.PATH_MEMBER_IMAGE.$user['image'];                    
    } 

    if($user['payment_status']==Subscription::PAID){
        $status="Paid";
    }elseif($user['payment_status']==Subscription::LATE){
        $status="Late";
    }
?>
<!--- header end ----> 
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/default_navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Home</li>
    </ol>
    </nav>
    <!-- module container -->
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between border border-secondary rounded" style="background-color:silver;">
                <div class="col-3">
                   <img src="<?php echo $path; ?>" width="auto" height="auto" class="img-responsive img-thumbnail float-left rounded-circle" alt="User Image"/>
                </div>
                <div class="col-9 d-flex flex-row">
                    <div class="col-6">
                        <h3 class="text-uppercase">Member</h3>
                        <p><b>Name :</b> <?php echo ucfirst($user['first_name'])." ".ucfirst($user['last_name']); ?></p>
                        <p><b>Email :</b> <?php echo $user['email']; ?></p>
                        <p><b>Phone :</b> <?php echo $user['telephone']; ?></p>
                    </div>
                    <div class="col-6">
                        <h3 class="text-uppercase">Membership</h3>
                        <p><b>Package :</b> <?php echo $user['package_name'] ?></p>
                        <p><b>Payment Status :</b> <span style="font-size: 16px;" class="badge <?php if($user['payment_status']==Subscription::PAID){echo "badge-success";}else{echo "badge-danger";}?>"><?php echo $status; ?></span></p>
                        <p><b>Next Payment Date :</b> <?php echo date('Y-m-d',strtotime($user['end_date'])); ?></p>
                    </div>
                </div>
            </div>         
        </div>
        <div class="row">
            
        </div>
    </div>
    <?php include_once '../../layout/default_footer.php';?>