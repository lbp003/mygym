<!--- header  ---->
<?php include '../../layout/header.php'; ?>
<?php 
    $memData = $_SESSION['memData'];
    // var_dump($memData); exit;
    $pacData = $_SESSION['pacData'];

    $gender = ['M' => 'Male', 'F' => 'Female'];

?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Member</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Update Member</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
                <form method="post" id="updateMember" name="updateMember" action="../../../controller/memberController.php?status=Update" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6" style="text-align:center">
                        <div class="kv-avatar">
                            <div class="file-loading">
                                <input id="avatar" name="avatar" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" aria-describedby="first_name" placeholder="First Name" value="<?php echo $memData['first_name']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" aria-describedby="last_name" placeholder="Last Name" value="<?php echo $memData['last_name']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Email" value="<?php echo $memData['email']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="">Choose...</option>
                            <?php foreach($gender as $key => $val){ ?>
                                <option value="<?php echo $key?>" <?php echo ($key == $memData['gender']) ? "selected" : NULL ?>><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="dob">Date of Birth</label>
                        <input type="text" class="form-control" id="dob" name="dob" aria-describedby="dob" placeholder="Date of Birth" value="<?php echo $memData['dob']?>" autocomplete="off">
                    </div>
                    <div class="form-group col-6">
                        <label for="nic">NIC</label>
                        <input type="text" class="form-control" id="nic" name="nic" aria-describedby="nic" placeholder="NIC" value="<?php echo $memData['nic']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phone" placeholder="Phone" value="<?php echo $memData['telephone']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="package">Package</label>
                        <select id="package" name="package" class="form-control">
                            <option value="">Choose...</option>
                            <?php foreach($pacData as $key => $val){?>
                            <option value="<?php echo $key;?>" <?php echo ($key == $memData['package_id']) ? "selected" : NULL ?>><?php echo $val;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="joined_date">Joined Date</label>
                        <input type="text" class="form-control" id="joined_date" name="joined_date" aria-describedby="joined_date" autocomplete="off" value="<?php echo $memData['joined_date']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="membership_number">Membership Number</label>
                        <input type="text" class="form-control" id="membership_number" name="membership_number" aria-describedby="membership_number" placeholder="Membership Number"  value="<?php echo $memData['membership_number']?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo $memData['address']?></textarea>
                    </div>
                    <div class="col-12">
                        <input type="hidden" name="image" value="<?php echo $memData['image']?>"> 
                        <input type="hidden" name="member_id" value="<?php echo $memData['member_id']?>"> 
                        <button type="submit" class="btn btn-primary mb-2 float-right">Submit</button>
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
        $('#updateMember').validate({
            rules: {
                first_name: "required",
                last_name: "required", 
                email: {
					required: true,
					email: true,
                    remote: '../../../controller/memberController.php?status=checkUpdateEmail&member_id=<?php echo $memData['member_id']?>'
				},
                dob: {
                    required: true,
                    date: true
                },
                gender: "required",
                nic: "required",
                phone: {
                    required: true,
                    minlength: 10
                },
                address: "required",
                avatar: {
                required: false,
                extension: "JPEG|JPG"
                },
                package: "required",
                membership_number: "required"


            },
            messages: {
                first_name: {
                    required: "Please enter first name"
                },
                last_name: {
                    required: "Please enter last name"
                },
                email: {
                    required: "Please enter email address",
                    remote: "Email address is already taken"
                },
                dob: {
                    required: "Please enter birth date"
                },
                gender: {
                    required: "Please enter gender"
                },
                nic: {
                    required: "Please enter NIC"
                },
                phone: {
                    required: "Please enter phone",
                    minlength: "Invalid phone number"
                },
                address: {
                    required: "Please enter address"
                },
                package: {
                    required: "Please select a package"
                },
                membership_number:{
                    required: "Please enter membership number"
                }
            }
        });

        <?php 
            if(!empty($memData['image'])){ ?>
                var path = "<?php echo "../../../".PATH_IMAGE.PATH_MEMBER_IMAGE.$memData['image']; ?>";   
                // console.log(path);
        <?php } ?>

        $("#avatar").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="fas fa-trash-alt"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<?php if(!empty($memData['image'])){ ?><img src="'+ path +'" width="100" height="auto" class="img-responsive img-thumbnail" /> <?php }else{ ?> <i class="fas fa-user fa-7x"></i> <?php } ?>',
            layoutTemplates: {main2: '{preview} {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif", "jpeg"],
            minFileCount : 0,
            maxFileCount: 1,
            showUpload: true,
            previewFileType: 'any',
            initialPreviewFileType: 'image',
        });

        $( "#joined_date" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
        });

        $( "#dob" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
        });
    });
</script>