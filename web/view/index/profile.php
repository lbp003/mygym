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
    }elseif($user['payment_status']==Subscription::PENDING){
        $status="Pending";
    }

    if($user['gender']==Member::MALE){
        $gender="Male";
    }else{
        $gender="Female";
    }
?> 
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/default_navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">My Profile</a></li>
    </ol>
    </nav>
    <!-- module container -->
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <div class="col-4 pl-5">
                    <br />
                   <img src="<?php echo $path; ?>" width="200px;" height="auto" class="img-responsive rounded-circle float-left" alt="User Image"/>
                </div>
                <div class="col-8 d-flex flex-column" style="padding-top:20px;">
                    <h3 class="text-uppercase">Member Profile<hr /></h3>
                    
                        <p><b>Name :</b> <?php echo ucfirst($user['first_name'])." ".ucfirst($user['last_name']); ?></p>
                        <p><b>Gender :</b> <?php echo $gender; ?></p>
                        <p><b>Email :</b> <?php echo $user['email']; ?></p>
                        <p><b>Phone :</b> <?php echo $user['telephone']; ?></p>
                        <p><b>NIC :</b> <?php echo $user['nic']; ?></p>
                        <p><b>Date of birth :</b> <?php echo $user['dob']; ?></p>
                        <p><b>Address :</b> <?php echo $user['address']; ?></p>
                        <br />
                    <h3 class="text-uppercase">Membership Details<hr /></h3>
                    
                        <p><b>Membership Number :</b> <?php echo $user['membership_number'] ?></p>
                        <p><b>Package :</b> <?php echo $user['package_name'] ?></p>
                        <p><b>Payment Status :</b> <span style="font-size: 16px;" class="badge <?php if($user['payment_status']==Subscription::PAID){echo "badge-success";}elseif($user['payment_status']==Subscription::LATE){echo "badge-danger";}else {echo "badge-warning";}?>"><?php echo $status; ?></span></p>
                        <p><b>Next Payment Date :</b> <?php echo date('Y-m-d',strtotime($user['end_date'])); ?></p>
                </div>
            </div>         
        </div>
        <div class="row">
            
        </div>
    </div>
    <?php include_once '../../layout/default_footer.php';?>