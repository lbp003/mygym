<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ---->
<?php include '../model/memberModel.php'; ?> <!-- including member model ----->
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $obm = new CommonFun();
    $resultm=$obm->viewRoleModule($role_id);
    //echo $userDetails['gender'].$userDetails['dob'];
    //print_r($resultm);
?>
<?php 
//    $objRo = new CommonFun();
//    $resultRo=$objRo->viewRole();
//    $_SESSION['resultRo']=$resultRo;
//    //print_r($resultRo);

    $member_id = $_REQUEST['member_id'];
    $obmeUp = new member();
    $result = $obmeUp->displayMember($member_id);
    if(!$result){
        die("ERROR".mysqli_error($con));
    }
    $resultUpMe =$result->fetch_assoc();
    
    // Create an array for staff record
   // $abc=$result->fetch_assoc();
    //if(!$abc){
   //     die("Query FAILED".mysqli_error($con));
    //} else {
//echo $abc[staff_fname];        
//}
   
?>
<body onload="startTime()">
        <!---navbar starting ---------->
        <?php include '../common/navBar.php';?> 
        <!---navbar ending ---------->
                <!--- breadcrumb starting--------->
        <div class="container-fluid">
                <div class="row">
                    <ol class="breadcrumb" style="background-color:#2f2f2f">
                        <li><a href="Dashboard.php" >Dashboard</a></li>
                        <li><a href="member.php" >Member</a></li>
                        <li><a href="#" class="active">Update Member</a></li>
                    </ol>
                </div>
        </div>
        <!--- breadcrumb ending--------->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                <!----Admin side nav starting------>
            <?php include '../common/AdminSideNav.php'; ?>
                <!----Admin side nav ending------>
                </div>
                <div class="col-md-9" style="background-color:rgb(250,250,250); ">
                    <div>
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Update Member</b></h1>
                    </div><hr />
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <?php if(isset($_REQUEST['msg'])){ 
                                $msg= base64_decode($_REQUEST['msg']);
                            ?>
                            <span class="alert alert-danger"><?php echo $msg; ?></span>
                                
                            <?php   } ?>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="error_msg" style="text-align: center" >&nbsp;</div>
                            <div>&nbsp;</div>
                        </div>
                        
                    </div>
                    <form method="post" name="UpdateMember" action="../controller/membercontroller.php?status=Update&member_id=<?php echo $member_id;?>" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" class="form-control" id="fname"  value="<?php echo $resultUpMe['member_fname'];?>">
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" class="form-control" id="lname" value="<?php echo $resultUpMe['member_lname'];?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo $resultUpMe['member_email'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" id="dob" value="<?php echo $resultUpMe['dob'];?>">
                            </div>
                            <div class="form-group">
                                <label for="gender" id="gender">Gender</label><br/>
                                <input type="radio" class="radio radio-inline" id="male" name="gender" value="Male" <?php if(strtolower($resultUpMe['gender'])=="male") echo "Checked"?>> &nbsp;&nbsp;Male
                                <input type="radio" class="radio radio-inline" id="female" name="gender" value="Female" <?php if(strtolower($resultUpMe['gender'])=="female") echo "Checked"?>> &nbsp;&nbsp;Female
                            </div>
                            <div class="form-group">
                                <label for="image">Image input</label>
                                <input type="file" id="img" name="member_image" class="form-control"><br />
                                <?php 
                                    if($resultUpMe['member_image']==""){
                                        $path="../images/user.png";
                                    }else{
                                        $path="../images/member_image/".$resultUpMe['member_image'];
                                    }
                                ?>
                                <img id="img_prev" src="<?php echo $path;?>" width="80px"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="tel">Telephone</label>
                                <input name="tel" type="text" class="form-control" id="tel" value="<?php echo $resultUpMe['member_tel'];?>">
                            </div>
                             <div class="form-group">
                                <label for="address">Address</label>
                                <textarea type="text" class="form-control" id="address" name="address" rows="5"><?php echo $resultUpMe['address'];?></textarea>
                            </div>
                             <div class="form-group"><br />
                                <label for="nic">NIC</label>
                                <input type="text" class="form-control" id="nic" name="nic" value="<?php echo $resultUpMe['nic'];?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                           <div class="row">
                            <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-4">
                                <a  href="member.php" class="btn btn-lg btn-danger btn-block" name="cancel" value="Cancel">Cancel</a>
                                <button class="btn btn-lg btn-info btn-block" name="submit" type="submit" value="Update">Update</button>
                            </div>
                            <div class="col-md-4">&nbsp;</div>
                        </div> 
                        </div>
                    </form>
                </div>
        </div><br />
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>
<script type="text/javascript">
    $(document).ready(function(){
       $('form').submit(function(){
           
           
       var fname=$('#fname').val();
       var lname=$('#lname').val();
       var email=$('#email').val();
       var dob=$('#dob').val();
       //var role_id=$('#role_id').val();
       var nic=$('#nic').val();
       var tel=$('#tel').val(); 
       var image=$('#img').val();
              
        var pat_nic=/^[0-9]{9}[vVxX]$/;
        var pat_tel=/^\+94[0-9]{9}$/;
        //var pat_email=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/; 
       
        
      if(fname==""){
           $('#error_msg').text("First Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#fname').focus();
           return false; //
       }
       if(lname==""){
           $('#error_msg').text("Last Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#lname').focus();
           return false; //
       }
//       if(email==""){
//           $('#error_msg').text("Email Address is empty");//To display error
//           $('#error_msg').addClass('alert-danger');
//           $('#email').focus();
//           return false; //
//       }
//       if(!(email.match(pat_email))){ //To check email validity
//           $('#error_msg').text("Email Address is invalid");//To display error
//           $('#error_msg').addClass('alert-danger');
//           $('#email').focus();
//           return false; //
//       }
//       
//       var res=$('#res').val();
//       if(res==0){
//          $('#email').select();
//           return false;
//       }
       
       
       if($('input[name=gender]:checked').length<=0)
        {
           $('#error_msg').text("Please select a Gender");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#gender').addClass('alert-danger');
           return false;
        }
       if(dob==""){
           $('#error_msg').text("Date of Birth is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#dob').focus();
           return false; //
       }
       //To check dob range
       //Current Date
        var current= new Date();
        var cyear=current.getFullYear();
        var cmonth=current.getMonth();
        var cdate=current.getDate();
        //Birth Date
        var birth= new Date(dob);
        var byear=birth.getFullYear();
        var bmonth=birth.getMonth();
        var bdate=birth.getDate();
        
        var age=cyear-byear;
        var m=cmonth-bmonth;
        var d=cdate-bdate;
        
        if(m<0 || (m==0 && d<0)){
            age--;
        }
       
       if(age < 12){
           $('#error_msg').text("Under Age");
           $('#error_msg').addClass('alert-danger');
           $('#dob').focus();
           return false;   
        
       }
       if(age > 75){
           $('#error_msg').text("over Age");
           $('#error_msg').addClass('alert-danger');
           $('#dob').focus();
           return false;         
       }           
       if(nic!="" && !(nic.match(pat_nic))){
           $('#error_msg').text("NIC is invalid");
           $('#error_msg').addClass('alert-danger');
           $('#nic').focus();
           return false; //              
       }       
       //To compare DOB and NIC
       if(dob!="" && nic!=""){
          var doby=dob.substring(2,4);
          var nicy=nic.substring(0,2);
          if(doby!=nicy){
            $('#error_msg').text("DOB and NIC are not matching");
            $('#error_msg').addClass('alert-danger');
            return false;
          }
           
       }
       if(tel==""){
           $('#error_msg').text("Telephone is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#tel').focus();
           return false; //
       }
       if(tel!="" && !(tel.match(pat_tel))){
           $('#error_msg').text("Telephone No is invalid");
           $('#error_msg').addClass('alert-danger');
           $('#tel').focus();
           return false;         
           
       }
   
       
//       if(role_id==""){
//           $('#error_msg').text("Role Name is empty");//To display error
//           $('#error_msg').addClass('alert-danger');
//           $('#role_id').focus();
//           return false; //
//       }   
       
      if(image!=""){
       var arr=image.split(".");
       var last=arr.length-1;
       var iext=arr[last].toLowerCase();
       var extarr=['jpg','jpeg','gif','png','tiff','svg'];
       if($.inArray(iext,extarr)==-1){
           $('#error_msg').text("Invalid extension");
           $('#error_msg').addClass('alert-danger');
           $('#img').focus();
           return false; //  
           
       }   
       }
       
       
       
    });
    
});  

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_prev')
            .attr('src', e.target.result)
            .height(70);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

</script>