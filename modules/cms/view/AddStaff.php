<!--- header start ---->
<?php include '../common/adHeader.php'; ?>
<!--- header end ---->
<?php
    $userDetails=$_SESSION['userDetails'];
    $role_id=$userDetails['role_id'];
    $objRo = new CommonFun();
    $resultm=$obm->viewRoleModule($role_id);
    //echo $userDetails['gender'].$userDetails['dob'];
    //print_r($resultm);

    $resultRo=$objRo->viewRole();
    //$_SESSION['resultRo']=$resultRo;
    //print_r($resultRo);
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
                        <li><a href="staff.php" >Staff</a></li>
                        <li><a href="#" class="active">Add Staff</a></li>
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
                        <h1 align="center" style="font-family: monospace; font-size: 60px;color: #ffff00;background-color:rgba(70,70,70,0.5);"><b>Add Staff</b></h1>
                    </div><hr />
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <?php if(isset($_REQUEST['msg'])){ 
                                $msg= base64_decode($_REQUEST['msg']);
                            ?>
                            <span class="alert alert-danger"><?php echo $msg; ?></span>
                                
                            <?php   } ?>
                            
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div id="error_msg" style="text-align: center" >&nbsp;</div>
                            <div>&nbsp;</div>
                        </div>
                        </div>
                    </div><br />
                    <form method="post" name="AddStaff" action="../controller/staffcontroller.php?status=Add" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name" >
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name" >
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="yourEmail@abc.com" onkeyup="showEmail(this.value)" >
                                <div id="showEmail"></div>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" id="dob" placeholder="mm/dd/yyyy" >
                            </div>
                            <div class="form-group" id="gender">
                                <label for="gender">Gender</label><br/>
                                <input type="radio" class="radio radio-inline" id="male" name="gender" value="Male" > &nbsp;&nbsp;Male
                                <input type="radio" class="radio radio-inline" id="female" name="gender" value="Female" > &nbsp;&nbsp;Female
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="tel">Telephone</label>
                                <input name="tel" type="text" class="form-control" id="tel" placeholder="+94123456789" >
                            </div>
                             <div class="form-group">
                                <label for="address">Address</label>
                                <textarea type="text" class="form-control" id="address" name="address" placeholder="Address" rows="4" ></textarea>
                            </div>
                             <div class="form-group">
                                <label for="nic">NIC</label>
                                <input type="text" class="form-control" id="nic" name="nic" placeholder="978976345V" >
                            </div>
                             <div class="form-group">
                                <label for="image">Image input</label>
                                <input type="file" id="img" name="staff_image" class="form-control" onchange="readURL(this)">
                                <img id="img_prev" />
                            </div>
                             <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" name="role" id="role_id" >
                                    <option>Select Role</option>
                                    <?php while ($rowRole=$resultRo->fetch_assoc()){
                                    if($rowRole['role_name']=='member'){    
                                        echo "<option value=".$rowRole['role_id']." style='display: none'>".$rowRole['role_name']."</option>";
                                    
                                    }else{
                                       echo "<option value=".$rowRole['role_id'].">". ucfirst($rowRole['role_name'])."</option>"; 
                                    }
                                    }?>
                                    
                                </select>
                            </div>
                            </div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"><br /><br />
                                <button class="btn btn-lg btn-danger btn-block" name="reset" type="reset" value="Reset">Reset</button>
                                <button class="btn btn-lg btn-info btn-block" id="submit" name="submit" type="submit" value="Submit">Submit</button>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </form>
                </div>
        </div>
<!---- Footer start---->
<?php include '../common/adFooter.php'; ?>
<!---- Footer end------>
<script type="text/javascript">
//To check email
function showEmail(str) {
    $('#error_msg').text('');
    $('#error_msg').removeClass('alert-danger');
  var xhttp; 
  if (str == "") {
    document.getElementById("showEmail").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
  
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("showEmail").innerHTML = this.responseText;
    
    }
  };
  xhttp.open("GET", "getEmail.php?status=staff&email="+str, true);
  xhttp.send();
  
}
</script>
<script type="text/javascript">
    $(document).ready(function(){
       $('form').submit(function(){
           
           
       var fname=$('#fname').val();
       var lname=$('#lname').val();
       var email=$('#email').val();
       var dob=$('#dob').val();
       var role_id=$('#role_id').val();
       var nic=$('#nic').val();
       var tel=$('#tel').val(); 
       var image=$('#img').val();
              
        var pat_nic=/^[0-9]{9}[vVxX]$/;
        var pat_tel=/^\+94[0-9]{9}$/;
        var pat_email=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/; 
       
        
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
       if(email==""){
           $('#error_msg').text("Email Address is empty");//To display error message
           $('#error_msg').addClass('alert-danger');
           $('#email').focus();
           return false; //
       }
       if(!(email.match(pat_email))){ //To check email validity with regx
           $('#error_msg').text("Email Address is invalid");//To display error message
           $('#error_msg').addClass('alert-danger');
           $('#email').focus();
           return false;
       }
       
       var res=$('#res').val();
       if(res==0){
          $('#email').select();
           return false;
       }
       
       
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
       if(tel!="" && !(user_tel.match(pat_tel))){
           $('#error_msg').text("Telephone No is invalid");
           $('#error_msg').addClass('alert-danger');
           $('#tel').focus();
           return false; //        
           
       }
   
       
       if(role_id==""){
           $('#error_msg').text("Role Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#role_id').focus();
           return false; //
       }   
       
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