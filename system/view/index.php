<?php include_once '../common/header.php';?><!---including header--->
<?php include '../common/navBar.php';?><!----- including navbar------>
        <div class="container-fluid">
             <div class="row">
            <div class="col-md-12">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
                    <section class="carousel-inner">
                        <div class=" item active">
                            <img src="../images/xyz.jpg" alt="abc" width="100%" height="auto"/>
                            <div class="carousel-caption">
                                <div class="jumbotron" id="jumbotron-in">
                                    <h1>Be FIT,LIVE Healthy</h1>
                                    <a href="register.php" class="btn btn-lg btn-danger">Join Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="item "><img src="../images/abc.jpg" alt="xyz"/></div>
                        <div class="item "><img src="../images/efg.jpg" alt="efg"/></div>
                    </section>
                   
                    <a href="#myCaousel" class="left carousel-control" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                    <a href="#myCaousel" class="right carousel-control" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>            
        </div>
        </div>
       <?php include_once '../common/footer.php';?><!-----including footer---->