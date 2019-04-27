<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="d-flex justify-content-center">
                    <a href="#" class="ml-2">Home</a>&nbsp;&nbsp;|
                    <a href="#" class="ml-2">Gallery</a>&nbsp;&nbsp;|
                    <a href="#" class="ml-2">Schedule</a>&nbsp;&nbsp;|
                    <a href="#" class="ml-2">Events</a>&nbsp;&nbsp;|
                    <a href="#" class="ml-2">My Login</a>&nbsp;&nbsp;|
                    <a href="#" class="ml-2">Contact Us</a>&nbsp;&nbsp;|
                    <a href="#" class="ml-2">About</a><br />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-row-reverse mr-3">
                    <a href="#"><i class="fab fa-twitter-square fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;
                    <a href="#"><i class="fab fa-facebook-square fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;
                    <a href="#"><i class="fab fa-youtube-square fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;            
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small>LBP Creations &COPY; <?php echo date("Y"); ?> | Z GYM | All Rights Reserved </small>
            </div>
        </div>
    </div>
</footer>
<!----script area ------>
<script type="text/javascript">
    $(document).ready(function() {
        $('.thumbnail').click(function(){
        $('.modal-body').empty();
  	    var title = $(this).parent('a').attr("title");
  	    $('.modal-title').html(title);
  	    $($(this).parents('div').html()).appendTo('.modal-body');
  	    $('#myModal').modal({show:true});
    });
});
</script>
        <script type="text/javascript" src="../../public/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    </body>
</html>