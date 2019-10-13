<!--- header start ---->
<?php include_once '../../layout/header.php'; ?>
<?php 
    if(empty($user['image'])){
        $path = "../../../".PATH_IMAGE."user.png"; 
    }else{ 
        $path = "../../../".PATH_IMAGE.PATH_STAFF_IMAGE.$user['image'];                    
    } 
   
    if($user['gender']== "M"){
        $gender="Male";
    }else{
        $gender="Female";
    }
?>
<!--- header end ----> 
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">My Profile</a></li>
    </ol>
    </nav>
    <!-- module container -->
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <div class="col-4 pl-5">
                    <br />
                   <img src="<?php echo $path; ?>" width="200px;" height="auto" class="img-responsive img-thumbnail float-left" alt="User Image"/>
                </div>
                <div class="col-8 d-flex flex-column profile-text" style="padding-top:20px;">
                    <h2 class="text-uppercase pb-3">Employee Profile<hr /></h2>

                        <p><b>Name :</b> <?php echo ucfirst($user['first_name'])." ".ucfirst($user['last_name']); ?></p>
                        <p><b>Gender :</b> <?php echo $gender; ?></p>
                        <p><b>Email :</b> <?php echo $user['email']; ?></p>
                        <!-- <p><b>Staff Type :</b> <?php echo $user['staff_type']; ?></p> -->
                        <p><b>Phone :</b> <?php echo $user['telephone']; ?></p>
                        <p><b>NIC :</b> <?php echo $user['nic']; ?></p>
                        <p><b>Date of birth :</b> <?php echo $user['dob']; ?></p>
                        <p><b>Joined Date :</b> <?php echo $user['joined_date']; ?></p>
                        <p><b>Address :</b> <?php echo $user['address']; ?></p>
                </div>
            </div>         
        </div>
        <div class="row">
            
        </div>
    </div>
    <?php include_once '../../layout/footer.php';?>