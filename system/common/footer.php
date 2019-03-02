 <footer>
            <div class="container-fluid">
                <div class="row">
                    <div class="footer">
                        <div class="container">
                        <div class="foo">
                            <div class="col-lg-3">
                                <a href="#"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-youtube-square fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a> <br /><br />
                                
                            </div>
                            <div class="col-lg-9">
                                <div class="foo-nav">
                                        <a href="#">Home</a>&nbsp;&nbsp;|
                                        <a href="#">Gallery</a>&nbsp;&nbsp;|
                                        <a href="#">Schedule</a>&nbsp;&nbsp;|
                                        <a href="#">Events</a>&nbsp;&nbsp;|
                                        <a href="#">Register</a>&nbsp;&nbsp;|
                                        <a href="#">My Login</a>&nbsp;&nbsp;|
                                        <a href="#">Contact Us</a>&nbsp;&nbsp;|
                                        <a href="#">About</a><br />
                                </div>
                        </div>
                        </div>
                        
                    </div>
                        <div class="row">
                    <div class="col-md-12">
                        <small style="color: #ffffff; float: left;">LBP Creations &COPY; <?php echo date("Y"); ?> | Z GYM | All Rights Reserved </small>
                    </div>
                </div>
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
        <script type="text/javascript" src="../admin/bootstrap/bootstrap-3.3.7/js/bootstrap.min.js"></script>
        <!--<script type="text/javascript" src="../jquery/jquery-3.3.1.min.js"></script>-->
        <script type="text/javascript" src="../admin/DataTables/datatables.min.js"></script>
        <script type="text/javascript" src="../assets/js/main.js"></script>
        <script type="text/javascript" src="../assets/js/modernizr.js"></script>
    </body>
</html>