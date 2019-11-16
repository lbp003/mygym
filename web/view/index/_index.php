<?php include_once '../../layout/header.php';?><!---including header--->
<?php include_once '../../layout/navBar.php';?><!----- including navbar------>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="demo" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                    <li data-target="#demo" data-slide-to="2"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../../../public/image/xyz.jpg" alt="image1" width="1100" height="auto">
                    </div>
                    <div class="carousel-item">
                        <img src="../../../public/images/web/efg.jpg" alt="image2" width="1100" height="auto">
                    </div>
                    <div class="carousel-item">
                        <img src="../../../public/images/web/abc.jpg" alt="image3" width="1100" height="auto">
                    </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>            
        </div>
    </div>
<?php include_once '../../layout/footer.php';?><!-----including footer---->