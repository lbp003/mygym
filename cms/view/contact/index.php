<!--- header  ---->
<?php
include '../../layout/header.php'; ?>
<?php 
    $memberList = $_SESSION['memberList'];

?>
<body>
    <!---navbar starting ---------->
    <?php include '../../layout/navBar.php';?> 
    <!---navbar ending ---------->
    <!--- breadcrumb starting--------->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="../dashboard/dashboard.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Send Email</a></li>
    </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="post" id="sendmail" name="sendmail" action="../../../controller/contactController.php?status=SendMail" enctype="multipart/form-data">
                <div class="d-flex flex-wrap">
                    <div class="form-group col-6">
                        <label for="class">Recipient/s</label>
                        <select class="js-example-basic-multiple form-control" id="email" name="email[]" multiple="multiple" required>
                            <option value="" disabled>Select Member/s</option>    
                            <?php foreach($memberList as $key => $val){?>
                            <option value="<?php echo $key;?>"><?php echo $val;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" aria-describedby="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="msg">Message</label>
                        <textarea class="form-control" id="msg" name="msg" rows="3"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mb-2 float-right">Send</button>
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

        //Use Select2 plugin
        $('.js-example-basic-multiple').select2();

        // Form validation
        $('#sendmail').validate({
            rules: {
                email: {
                    required: true
                },
                subject: "required", 
                msg: "required"
            },
            messages: {
                email: {
                    required: "Select member/s"
                },
                subject: {
                    required: "Please enter subject"
                },
                msg: {
                    required: "Please enter message"
                }
            }
        });
    });
</script>