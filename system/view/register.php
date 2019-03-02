<?php include '../common/header.php';?>
<!----nav bar starting ----------->
        <?php include '../common/navBar.php';?>
        <!---navigation bar ending---->
        <?php include '../admin/model/memberModel.php';?><!----including member model ------>
        
        <?php 
        
        $member_id=$_REQUEST['member_id'];
        
        $objM = new member(); 
        $result = $objM->displayMember($member_id);
        
        $resultM = $result->fetch_assoc();
        
        ?>
        
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 reg-bg ">
            <div>
                <h1 align="center" style="font-size: 60px;color: #ffff00;background-color:rgba(72,72,72,0.7);font-family: monospace"><b>Join <span style="font-size: 36px">with us</span> Today &  Create Yourself </b></h1>
            </div><hr />
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                <div class="col-md-6 reg-form">
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <?php if(isset($_REQUEST['msg'])){ 
                                $msg= base64_decode($_REQUEST['msg']);
                            ?>
                            <p id="error_msg"><?php echo $msg; ?></p>
                                
                            <?php   } ?>
                            
                        </div>
                        <!--<div id="error_msg" style="text-align: center" >&nbsp;</div>-->
                    </div>
                    <form method="post" name="AddMember" action="../admin/controller/onlineMemberController.php?status=Update&member_id=<?php echo $member_id ?>" enctype="multipart/form-data" style="margin-top: 30px;">
                            <div class="form-group">
                                <label for="fname"></label>
                                <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="lname"></label>
                                <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="email"></label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo $resultM['member_email']?>" disabled="">
                            </div>
                            <div class="form-group">
                                <label for="dob">Date Of Birth</label>
                                <input type="date" name="dob" class="form-control" id="dob" placeholder="mm/dd/yyyy">
                            </div>
                            <div class="form-group">
                                <label for="gender"></label><br/>
                                <input type="radio" class="radio radio-inline" id="male" name="gender" value="Male"> &nbsp;&nbsp;Male
                                <input type="radio" class="radio radio-inline" id="female" name="gender" value="Female"> &nbsp;&nbsp;Female
                            </div>                   
                             <div class="form-group">
                                <label for="tel"></label>
                                <input name="tel" type="text" class="form-control" id="tel" placeholder="Telephone : +94123456789">
                            </div>
                             <div class="form-group">
                                <label for="address"></label>
                                <textarea type="text" class="form-control" id="address" name="address" placeholder="Address" rows="4"></textarea>
                            </div>
                             <div class="form-group">
                                <label for="nic"></label>
                                <input type="text" class="form-control" id="nic" name="nic" placeholder="NIC">
                            </div>
                             <div class="form-group">
                                <label for="image">Image input</label>
                                <input type="file" id="img" name="member_image" onchange="readURL(this)>
                                <?php 
                                    if($resultM['member_image']==""){
                                        $path="../../images/user.png";
                                    }else{
                                        $path="../../images/member_image/".$resultM['member_image'];
                                    }
                                ?>
                                <img id="img_prev" src="<?php echo $path;?>" width="80px"/>
                            </div>                            
                            <div class="row">                               
                                <button class="btn btn-lg btn-danger btn-block" name="submit" type="submit" value="signup" style="width: 150px; float: right; margin-right: 20px;">ENTER</button>
                            </div>
                    </form>
                        </div>             
                </div>
                <div class="col-md-3">&nbsp;</div>
            </div>        
            
        </div>
    </div>
</div>
<?php include '../common/footer.php';?>
<script type="text/javascript">
    $(document).ready(function(){
       $('form').submit(function(){
           
           
       var fname=$('#fname').val();
       var lname=$('#lname').val();
       //var email=$('#email').val();
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