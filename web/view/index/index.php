<?php include_once '../../../config/dbconnection.php'; ?>
<?php include_once '../../../config/session.php'; ?>
<?php include_once '../../../config/global.php'; ?>
<?php include_once '../../../model/role.php'; ?>
<?php include_once '../../../model/class.php'; ?>
<?php
  $allClass = Programs::displayAllPrograms();
  // var_dump($allClass); exit;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo SYSTEM_BUSINESS_NAME;?> &mdash; Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
    <link rel="stylesheet" href="../../../public/theme/fonts/icomoon/style.css">

    <link rel="stylesheet" href="../../../public/theme/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/theme/css/magnific-popup.css">
    <link rel="stylesheet" href="../../../public/theme/css/jquery-ui.css">
    <link rel="stylesheet" href="../../../public/theme/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../../public/theme/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../../../public/theme/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../../../public/theme/css/animate.css">
    
    
    <link rel="stylesheet" href="../../../public/theme/fonts/flaticon/font/flaticon.css">
  
    <link rel="stylesheet" href="../../../public/theme/css/aos.css">

    <link rel="stylesheet" href="../../../public/theme/css/style.css">
    
  </head>
  <body>
  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    
    <div class="site-navbar-wrap bg-white">
      <div class="site-navbar-top">
        <div class="container py-2">
          <div class="row align-items-center">
            <div class="col-6">
              <a href="#" class="p-2 pl-0"><span class="icon-twitter"></span></a>
              <a href="#" class="p-2 pl-0"><span class="icon-facebook"></span></a>
              <a href="#" class="p-2 pl-0"><span class="icon-linkedin"></span></a>
              <a href="#" class="p-2 pl-0"><span class="icon-instagram"></span></a>
            </div>
            <div class="col-6">
              <div class="d-flex ml-auto">
                <a href="login.php" class="d-flex align-items-center ml-auto mr-4">
                  <span class="icon-user mr-2"></span>
                  <span class="d-none d-md-inline-block">Sign In</span>
                </a>
                <a href="#" class="d-flex align-items-center mr-4">
                  <span class="icon-envelope mr-2"></span>
                  <span class="d-none d-md-inline-block"><?php echo BUSINESS_EMAIL;?></span>
                </a>
                <a href="tel://<?php echo BUSINESS_PHONE;?>" class="d-flex align-items-center">
                  <span class="icon-phone mr-2"></span>
                  <span class="d-none d-md-inline-block"><?php echo BUSINESS_PHONE;?></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="site-navbar-wrap bg-white">
      
      <div class="container">
        <div class="site-navbar bg-light">
          <div class="py-1">
            <div class="row align-items-center">
              <div class="col-4">
                <h2 class="mb-0 site-logo"><a href="#"><strong>HIRU</strong> FITNESS CENTER</a></h2>
              </div>
              <div class="col-8">
                <nav class="site-navigation text-right" role="navigation">
                  <div class="container">
                    <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                      <li class="active">
                        <a href="#">HOME</a>
                      </li>
                      <li><a href="services.html">GALLERY</a></li>
                      <li><a href="news.html">SCHEDULE</a></li> 
                      <li><a href="about.html">EVENTS</a></li>
                      <li><a href="contact.html">CONTACT</a></li>
                    </ul>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  

    <div class="slide-one-item home-slider owl-carousel">
      
      <div class="site-blocks-cover" style="background-image: url(../../../public/theme/images/hero_bg_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7 text-center" data-aos="fade">
              <h1>Get In Shape &amp; Be <strong>Healthy</strong></h1>
            </div>
          </div>
        </div>
      </div>  

      <div class="site-blocks-cover" style="background-image: url(../../../public/theme/images/hero_bg_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7 text-center" data-aos="fade">
              <h1>Build Your <strong>Body</strong> Strong</h1>
            </div>
          </div>
        </div>
      </div> 
      

    </div>
    <div class="site-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-12 col-lg-5 mb-5 mb-lg-0">
            <h2 class="mb-3 text-uppercase">All About <strong class="text-black font-weight-bold">Our Gym</strong></h2>
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque accusamus, rerum illo facilis reiciendis.</p>
            <p class="mb-4">Iste aut dolorem veritatis saepe nesciunt distinctio voluptas sapiente sunt perspiciatis autem minima, iure provident. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, quas.</p>
            <ul class="site-block-check">
              <li>Lorem ipsum dolor sit amet, consectetur adipisicing.</li>
              <li>Nemo, voluptate? Voluptates odit, aperiam nostrum! Ipsa.</li>
              <li>Itaque voluptatum ducimus aliquam, est fuga molestiae?</li>
              <li>Accusamus porro at commodi delectus, nesciunt molestiae.</li>
            </ul>
            <!-- <p><a href="#" class="btn btn-primary pill px-4">Read More</a></p> -->
          </div>
          <div class="col-md-12 col-lg-6 ml-auto">
            <img src="../../../public/theme/images/about.jpg" alt="Image" class="img-fluid">
          </div>
        </div>
      </div>
    </div>

    <div class="featured-classes bg-light py-5 block-13">
      <div class="container">
        
        <div class="heading-with-border">
          <h2 class="heading text-uppercase">Featured Class</h2>
        </div>

        <div class="nonloop-block-13 owl-carousel">
        <?php 
          if(!$allClass){
            die("Query DEAD ".mysqli_error($con));
          }

          while($row = $allClass->fetch_assoc()) {
            
            if($row['image']==""){
                $path="../../../".PATH_IMAGE."user.png";
            } else {
                $path="../../../public/image/class_image/".$row['image'];                    
            }
          ?>
            <div class="block-media-1 heading-with-border bg-white">
              <img src="<?php echo $path; ?>" width="350" height="263" alt="Image" class="img-fluid">
              <div class="p-4">
                <h3 class="h5 heading"><?php echo ucwords($row['class_name']); ?></h3>
                <p><?php echo ucfirst($row['class_description']); ?></p>
              </div>
            </div>
        <?php } ?>
        </div>

      </div>
    </div>

    <div class="block-schedule overlay site-section" style="background-image: url('../../../public/theme/images/hero_bg_1.jpg');">
      <div class="container">

        <h2 class="text-white display-4 mb-5">Schedule</h2>

        <ul class="nav nav-pills tab-nav mb-4" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="pills-sunday-tab" data-toggle="pill" href="#pills-sunday" role="tab" aria-controls="pills-sunday" aria-selected="true">Sunday</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-monday-tab" data-toggle="pill" href="#pills-monday" role="tab" aria-controls="pills-monday" aria-selected="true">Monday</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-tuesday-tab" data-toggle="pill" href="#pills-tuesday" role="tab" aria-controls="pills-tuesday" aria-selected="false">Tuesday</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-wednesday-tab" data-toggle="pill" href="#pills-wednesday" role="tab" aria-controls="pills-wednesday" aria-selected="false">Wednesday</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-thursday-tab" data-toggle="pill" href="#pills-thursday" role="tab" aria-controls="pills-thursday" aria-selected="false">Thursday</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-friday-tab" data-toggle="pill" href="#pills-friday" role="tab" aria-controls="pills-friday" aria-selected="false">Friday</a>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-sunday" role="tabpanel" aria-labelledby="pills-sunday-tab">
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Running</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> David Holmes</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Weight Lifting</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> Bruce Mars</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Yoga</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> Josh White</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Running</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> David Holmes</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Weight Lifting</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> Bruce Mars</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>

          </div>

          <div class="tab-pane fade" id="pills-monday" role="tabpanel" aria-labelledby="pills-monday-tab">
            
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Weight Lifting</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> Bruce Mars</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Running</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> David Holmes</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Yoga</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> Josh White</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Running</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> David Holmes</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5">Weight Lifting</h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span>8:00am &mdash; 10:00am</div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> Bruce Mars</div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>

          </div>

          
        </div>

        

      </div>      
    </div>

    <div class="site-section block-14">

      <div class="container">
        
        <div class="heading-with-border text-center">
          <h2 class="heading text-uppercase">Testimonials</h2>
        </div>

        <div class="nonloop-block-14 owl-carousel">

          <div class="d-flex block-testimony">
            <div class="person mr-3">
              <img src="../../../public/theme/images/person_1.jpg" alt="Image" class="img-fluid rounded-circle">
            </div>
            <div>
              <h2 class="h5">Katie Johnson, CEO</h2>
              <blockquote>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias accusantium qui optio, possimus necessitatibus voluptate aliquam velit nostrum tempora ipsam!&rdquo;</blockquote>
            </div>
          </div>
          <div class="d-flex block-testimony">
            <div class="person mr-3">
              <img src="../../../public/theme/images/person_2.jpg" alt="Image" class="img-fluid rounded-circle">
            </div>
            <div>
              <h2 class="h5">Jane Mars, Designer</h2>
              <blockquote>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias accusantium qui optio, possimus necessitatibus voluptate aliquam velit nostrum tempora ipsam!&rdquo;</blockquote>
            </div>
          </div>
          <div class="d-flex block-testimony">
            <div class="person mr-3">
              <img src="../../../public/theme/images/person_3.jpg" alt="Image" class="img-fluid rounded-circle">
            </div>
            <div>
              <h2 class="h5">Shane Holmes, CEO</h2>
              <blockquote>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias accusantium qui optio, possimus necessitatibus voluptate aliquam velit nostrum tempora ipsam!&rdquo;</blockquote>
            </div>
          </div>
          <div class="d-flex block-testimony">
            <div class="person mr-3">
              <img src="../../../public/theme/images/person_4.jpg" alt="Image" class="img-fluid rounded-circle">
            </div>
            <div>
              <h2 class="h5">Mark Johnson, CEO</h2>
              <blockquote>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias accusantium qui optio, possimus necessitatibus voluptate aliquam velit nostrum tempora ipsam!&rdquo;</blockquote>
            </div>
          </div>

        </div>

      </div>
      
    </div>



    <div class="site-section bg-light">

      <div class="container">
        
        <div class="heading-with-border text-center mb-5">
          <h2 class="heading text-uppercase">Experts Trainer</h2>
        </div>

          <div class="row">

            <div class="col-lg-4 mb-4">
              <div class="block-trainer">
                <img src="../../../public/theme/images/person_4.jpg" alt="Image" class="img-fluid">
                <div class="block-trainer-overlay">
                  <h2>Jonah Smith</h2>
                  <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur quas iste corporis asperiores placeat earum.</p>
                  <p>
                    <a href="#" class="p-2"><span class="icon-facebook"></span></a>
                    <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                    <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                  </p>
                </div>
              </div>    
            </div>
            <div class="col-lg-4 mb-4">
              <div class="block-trainer">
                <img src="../../../public/theme/images/person_3.jpg" alt="Image" class="img-fluid">
                <div class="block-trainer-overlay">
                  <h2>Jonah Smith</h2>
                  <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur quas iste corporis asperiores placeat earum.</p>
                  <p>
                    <a href="#" class="p-2"><span class="icon-facebook"></span></a>
                    <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                    <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4">
              <div class="block-trainer">
                <img src="../../../public/theme/images/person_4.jpg" alt="Image" class="img-fluid">
                <div class="block-trainer-overlay">
                  <h2>Jonah Smith</h2>
                  <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur quas iste corporis asperiores placeat earum.</p>
                  <p>
                    <a href="#" class="p-2"><span class="icon-facebook"></span></a>
                    <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                    <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                  </p>
                </div>
              </div>    
            </div>
            <div class="col-lg-4 mb-4">
              <div class="block-trainer">
                <img src="../../../public/theme/images/person_3.jpg" alt="Image" class="img-fluid">
                <div class="block-trainer-overlay">
                  <h2>Jonah Smith</h2>
                  <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur quas iste corporis asperiores placeat earum.</p>
                  <p>
                    <a href="#" class="p-2"><span class="icon-facebook"></span></a>
                    <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                    <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="block-trainer">
                <img src="../../../public/theme/images/person_2.jpg" alt="Image" class="img-fluid">
                <div class="block-trainer-overlay">
                  <h2>Jonah Smith</h2>
                  <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur quas iste corporis asperiores placeat earum.</p>
                  <p>
                    <a href="#" class="p-2"><span class="icon-facebook"></span></a>
                    <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                    <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-4">
              <div class="block-trainer">
                <img src="../../../public/theme/images/person_1.jpg" alt="Image" class="img-fluid">
                <div class="block-trainer-overlay">
                  <h2>Jonah Smith</h2>
                  <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur quas iste corporis asperiores placeat earum.</p>
                  <p>
                    <a href="#" class="p-2"><span class="icon-facebook"></span></a>
                    <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                    <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                  </p>
                </div>
              </div>
            </div>

          </div>

      </div>
      
    </div>
    
    <footer class="site-footer">
      <div class="container">
        

        <div class="row">
          <div class="col-lg-7">
            <div class="row">
              <div class="col-6 col-md-4 col-lg-8 mb-5 mb-lg-0">
                <h3 class="footer-heading mb-4 text-primary">About</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat quos rem ullam, placeat amet sint vel impedit reprehenderit eius expedita nemo consequatur obcaecati aperiam, blanditiis quia iste in! Assumenda, odio?</p>
                <p><a href="#" class="btn btn-primary pill text-white px-4">Read More</a></p>
              </div>
              <div class="col-6 col-md-4 col-lg-4 mb-5 mb-lg-0">
                <h3 class="footer-heading mb-4 text-primary">Quick Menu</h3>
                <ul class="list-unstyled">
                  <li><a href="#">About</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">Approach</a></li>
                  <li><a href="#">Sustainability</a></li>
                  <li><a href="#">News</a></li>
                  <li><a href="#">Careers</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="row mb-5">
              <div class="col-md-12"><h3 class="footer-heading mb-4 text-primary">Contact Info</h3></div>
              <div class="col-md-6">
                <p>New York - 2398 <br> 10 Hadson Carl Street</p>    
              </div>
              <div class="col-md-6">
                Tel. + (123) 3240-345-9348 <br>
                Mail. usa@youdomain.com
              </div>
            </div>

            <div class="row">
              <div class="col-md-12"><h3 class="footer-heading mb-4 text-primary">Social Icons</h3></div>
              <div class="col-md-12">
                <p>
                  <a href="#" class="pb-2 pr-2 pl-0"><span class="icon-facebook"></span></a>
                  <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                  <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                  <a href="#" class="p-2"><span class="icon-vimeo"></span></a>

                </p>
              </div>
            </div>
            
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p>
              <small>LBP Creations &COPY; <?php echo date("Y"); ?> | All Rights Reserved </small>
            </p>
          </div>
          
        </div>
      </div>
    </footer>
  </div>

  <script src="../../../public/theme/js/jquery-3.3.1.min.js"></script>
  <script src="../../../public/theme/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../../../public/theme/js/jquery-ui.js"></script>
  <script src="../../../public/theme/js/popper.min.js"></script>
  <script src="../../../public/theme/js/bootstrap.min.js"></script>
  <script src="../../../public/theme/js/owl.carousel.min.js"></script>
  <script src="../../../public/theme/js/jquery.stellar.min.js"></script>
  <script src="../../../public/theme/js/jquery.countdown.min.js"></script>
  <script src="../../../public/theme/js/jquery.magnific-popup.min.js"></script>
  <script src="../../../public/theme/js/bootstrap-datepicker.min.js"></script>
  <script src="../../../public/theme/js/aos.js"></script>
  <script src="../../../public/theme/js/main.js"></script>
    
  </body>
</html>