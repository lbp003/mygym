<?php include '../common/header.php'; ?>
<?php include '../common/navBar.php';?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Contact &nbsp;<i class="fa fa-address-book"></i></h1>
            <p>Thanks for your interest in Z Gym. To contact us, just fill out the form or you can e-mail us or call us at the information listed below. 
                We look forward to helping you achieve your fitness goals!</p>
            <h1>Z Gym</h1>
            <p>No : 71/A/3/1,</p>
            <p>Negombo Road,</p>
            <p>Ja-Ela.</p>
            <h3><i class="fa fa-phone"></i> &nbsp;Tel: 0112235480</h3>
            <h3><i class="fa fa-envelope"></i> &nbsp;Email: lasithanishanzgym@gmail.com</h3>
        </div>
        <div class="col-md-6">
             <div class="panel panel-primary">
                    <div class="panel-heading"><h2>Contact Us</h2></div>
                    <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <?php if(isset($_REQUEST['msg'])){ 
                                $msg= base64_decode($_REQUEST['msg']);
                            ?>
                            <span><?php echo $msg; ?></span>
                                
                            <?php   } ?>
                            
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div id="error_msg" style="text-align: center" >&nbsp;</div>
                            <div>&nbsp;</div>
                        </div>
                        </div>
                    </div>
                    <form method="post" action="../admin/controller/contactController.php?status=Submit" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="fname">First Name :</label>
                                <input name="fname" type="text" class="form-control" id="fname" placeholder="David" />
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name :</label>
                                <input name="lname" type="text" class="form-control" id="lname" placeholder="Hussey" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email :</label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="david@example.com" />
                            </div>
                            <div class="form-group">
                                <label for="tel">Telephone :</label>
                                    <input name="tel" type="text" class="form-control" id="tel" placeholder="+94771888110" />
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject :</label>
                                <input name="subject" type="text" class="form-control" id="subject" placeholder="HAHAHAH" maxlength="50" />
                            </div>
                            <div class="form-group">
                                <label for="message">Message :</label>
                                <textarea type="text" class="form-control" id="msg" name="msg" rows="5" ></textarea>
                            </div>
                            <br />
                            <div>
                                <button type="submit" name="submit" value="Submit" class="btn btn-danger" style="float: right">Submit</button>
                            </div>
                        </form>
                            </div>
                    </div>
                
                </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
         <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15837.466144560509!2d79.8905745!3d7.0834373!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xef64157d732de522!2sZ+Gym!5e0!3m2!1sen!2slk!4v1499028667853" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>
</div>
<?php include '../common/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('form').submit(function(){
            
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var email = $('#email').val();
            var tel = $('#tel').val();
            var subject = $('#subject').val();
            var msg = $('#msg').val();
            
            var patname =/^[A-Za-z .'-]+$/;
            var patnic=/^[0-9]{9}[vVxX]$/;
            var pattel=/^\+94[0-9]{9}$/;
            var patemail=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/;
            
        if(fname==""){
           $('#error_msg').text("First Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#fname').focus();
           return false; //
        }
        if(!(fname.match(patname))){ //To check name validity
           $('#error_msg').text("First Name is invalid");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#email').focus();
           return false; //
        }
        if(lname==""){
           $('#error_msg').text("Last Name is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#lname').focus();
           return false; //
        }
        if(!(lname.match(patname))){ //To check name validity
           $('#error_msg').text("Last Name is invalid");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#email').focus();
           return false; //
        }
        if(email==""){
           $('#error_msg').text("Email Address is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#email').focus();
           return false; //
        }
        if(!(email.match(patemail))){ //To check email validity
           $('#error_msg').text("Email Address is invalid");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#email').focus();
           return false; //
        }
        if(tel==""){
           $('#error_msg').text("Telephone Address is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#tel').focus();
           return false; //
        }
        if(!(tel.match(pattel))){ //To check email validity
           $('#error_msg').text("Telephone is invalid");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#tel').focus();
           return false; //
        }
        if(subject==""){
           $('#error_msg').text("Subject is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#subject').focus();
           return false; //
        }
        if(msg==""){
           $('#error_msg').text("Message is empty");//To display error
           $('#error_msg').addClass('alert-danger');
           $('#msg').focus();
           return false; //
        }   
        });
    });
</script>

