<?php include '../common/header.php';?>
<!----nav bar starting ----------->
        <?php include '../common/navBar.php';?>
        <!---navigation bar ending---->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 reg-bg ">
            <div>
                <h1 align="center" style="font-size: 60px;color: #ffff00;background-color:rgba(72,72,72,0.7);font-family: monospace"><b>Join <span style="font-size: 36px">with us</span> Today &  Create Yourself </b></h1>
            </div>
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                <div class="col-md-6 reg-form">
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <?php if(isset($_REQUEST['msg'])){ 
                                $msg= base64_decode($_REQUEST['msg']);
                            ?>
                            <span><?php echo $msg; ?></span>
                                
                            <?php   } ?>
                            
                        </div>
                        <div id="error_msg" style="text-align: center" >&nbsp;</div>
                    </div>
                    <form name="form" method="post" name="AddMember" action="../admin/controller/onlineMemberController.php?status=Con" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="uname"></label>
                                <input type="text" name="uname" class="form-control" id="uname" placeholder="User Name">
                            </div> 
                            <div class="form-group">
                                <label for="email"></label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="yourEmail@abc.com" onkeyup="showEmail(this.value)">
                                <div id="showEmail"></div>
                            </div>                         
                            <div class="form-group">
                                <label for="pass"></label>
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="con_pass"></label>
                                <input type="password" class="form-control" id="con_pass" name="con_pass" placeholder="Confirm Password">
                            </div>                        
                            <div class="row">                               
                                <button class="btn btn-lg btn-danger btn-block" id="submit" name="submit" type="submit" value="signup" style="width: 150px; float: right; margin-right: 20px;">Sign Up</button>
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
  xhttp.open("GET", "getEmailOnline.php?m="+str, true);
  xhttp.send();
}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('form').submit(function(){
            var uname=$('uname').val();
            var email=$('#email').val();
            var pass=$('#pass').val();
            var con_pass=$('#con_pass').val();
         
         var pat_email=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/;
         
         if(uname==""){//check empty
           $('#error_msg').text("User Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#uname').focus();
           return false;
         }
         if(email==""){//check empty
           $('#error_msg').text("Email is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#email').focus();
           return false;
         }
         if(!(email.match(pat_email))){ //To check email validity
           $('#error_msg').text("Email Address is invalid");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#email').focus();
           return false; 
       }
       if(pass==""){
           $('#error_msg').text("Password is empty");
           $('#error_msg').addClass('alert-danger');
           $('pass').focus();
           return false;
       }
       if(pass.length < 8){
           $('#error_msg').text("Password must be at least 8 characters");
           $('#error_msg').addClass('alert-danger');
           $('pass').focus();
           return false;
       }
       if(pass!==con_pass){
           $('#error_msg').text("Password doesn't match confirmation");
           $('#error_msg').addClass('alert-danger');
           $('pass').focus();
           return false;
       }
        });
    });
</script>