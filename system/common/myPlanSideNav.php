<div class="side-nav">
                        <div><h1 align="center"><b>WELCOME</b><br />
                            <span id="txt"></span>
                            </h1></div>
                        <hr /><br />
                        <?php 
                            if($memberDetails['member_image']==""){
                                $path="../admin/images/user.png";
                            }else{
                                $path="../admin/images/member_image/".$memberDetails['member_image'];
                            }
                        ?>
                        <img src="<?php echo $path; ?>" width="150px" height="auto" class="img-responsive img-thumbnail center-block" />
                        <br />
                        <hr />
                        <section style="font-size: 14px">
                            <div class="row">
                                <div class="col-md-3"><p>Name </p></div>
                                <div class="col-md-9">
                                    <?php                            
                                        if($memberDetails['gender']=="male"){
                                            echo "<p>Mr.".ucfirst($memberDetails['member_fname'])." ".ucfirst($memberDetails['member_lname'])."</p>";
                                        }else{
                                            echo "<p>Mrs.</p>".ucfirst($memberDetails['member_fname'])." ".ucfirst($memberDetails['member_lname']);
                                        }
                                    ?>
                                </div>
                            </div><br />
                            <div class="row">
                                <div class="col-md-3"><p>Email </p></div>
                                    <div class="col-md-9">
                                        <?php                               
                                             echo $memberDetails['member_email'];
                                        ?>
                                    </div>
                            </div><br />
                            <div class="row">
                                <div class="col-md-3"><p>Tel </p></div>
                                    <div class="col-md-9">
                                        <?php                               
                                             echo $memberDetails['member_tel'];
                                        ?>
                                    </div>
                            </div>
                        </section>
                        <section>
                             <div>
                                <br/>
                                <a class="btn btn-default" style="background-color: #ff6666;" id="pw">Change Password</a>
                                <br/><br/>
                                <div id="cpw">
                                <form method="post" action="../admin/controller/passwordController.php?status=MCPW" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Current Password</label>
                                        <input class="form-control" type="password" name="current_pw" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input class="form-control" type="password" name="new_pw" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input class="form-control" type="password" name="con_pw" required/>
                                    </div>
                                    <div class="form-group" style="display: none">
                                        <label>Member Id</label>
                                        <input class="form-control" type="hidden" name="member_id" value="<?php echo $member_id;?>" required/>
                                    </div>
                                    <div>
                                        <button class="btn btn-success" name="submit" type="submit" value="submit" style="background-color: #99ff99">Submit</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <div><a href="../View/UpdateMember.php?member_id=<?php echo $member_id?>" class="btn btn-default" style="background-color: #ff6666;" id="pw">Edit Profile</a></div> 
                        </section> 
                        <div><br /><hr />
                            <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;height=200&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=en.lk%23holiday%40group.v.calendar.google.com&amp;color=%23A32929&amp;ctz=Asia%2FColombo" style="border-width:0;" width="90%" height="200" frameborder="0" scrolling="no"></iframe>
                        </div><br /><br />
</div>
<script type="text/javascript">
$(document).ready(function(){
    $( "#cpw" ).hide(function(){
       $("#pw").click(function(){
        $("#cpw").toggle(); 
     });                                 
    });
});
</script>
            