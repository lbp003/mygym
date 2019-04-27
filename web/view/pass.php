<?php include '../common/header.php';?>
<?php include '../common/navBar.php';?>
<div class="container">
    <div class="jumbotron" id="jumbotron-in">
        <h1>Thank You !</h1>

             <?php if(isset($_REQUEST['msg'])){ 
                 
                $msg= base64_decode($_REQUEST['msg']);
            ?>
        <p><?php echo $msg; ?></p>
                                
              <?php   } ?>
    </div>
</div>

<?php include_once '../common/footer.php';?>
