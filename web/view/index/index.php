<!-- including header -->
<?php include_once '../../layout/header.php'; ?>
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
              <a href="https://www.facebook.com/Hiru-fitness-centre-774379499563801" target="_blank" class="p-2 pl-0"><span class="icon-facebook"></span></a>
              <a href="#" class="p-2 pl-0"><span class="icon-instagram"></span></a>
            </div>
            <div class="col-6">
              <div class="d-flex ml-auto">
                <a href="login.php" class="d-flex align-items-center ml-auto mr-4">
                  <span class="icon-user mr-2"></span>
                  <span class="d-none d-md-inline-block">Sign In</span>
                </a>
                <a href="mailto:<?php echo BUSINESS_EMAIL?>?Subject=Contact%20Us" target="_top" class="d-flex align-items-center mr-4">
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
    <!-- include navigation bar -->
    <?php include_once '../../layout/navBar.php'; ?>
  
    <!-- <div class="slide-one-item home-slider owl-carousel"> -->
    <div>   
      <div class="site-blocks-cover" style="background-image: url(../../../public/theme/images/hero_bg_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7 text-center" data-aos="fade">
              <h1>Get In Shape &amp; Be <strong>Healthy</strong></h1>
            </div>
          </div>
        </div>
      </div>  

      <!-- <div class="site-blocks-cover" style="background-image: url(../../../public/theme/images/hero_bg_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7 text-center" data-aos="fade">
              <h1>Build Your <strong>Body</strong> Strong</h1>
            </div>
          </div>
        </div>
      </div>  -->
      

    </div>
    <div class="border-bottom">
      <div class="row no-gutters">
        <div class="col-md-6 col-lg-3">
          <div class="w-100 h-100 block-feature p-5 bg-light">
            <span class="d-block mb-3">
              <span class="flaticon-padmasana display-4"></span>
            </span>
            <h2>Fat Burning Special</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora fugiat iure eveniet perferendis odit est.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="w-100 h-100 block-feature p-5">
            <span class="d-block mb-3">
              <span class="flaticon-weight display-4"></span>
            </span>
            <h2>Juice Bar</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora fugiat iure eveniet perferendis odit est.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="w-100 h-100 block-feature p-5 bg-light">
            <span class="d-block mb-3">
              <span class="flaticon-boxing-gloves display-4"></span>
            </span>
            
            <h2>Fitness Store</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora fugiat iure eveniet perferendis odit est.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="w-100 h-100 block-feature p-5">
            <span class="d-block mb-3">
              <span class="flaticon-running display-4"></span>
            </span>
            <h2>Free Parking</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora fugiat iure eveniet perferendis odit est.</p>
          </div>
        </div>
      </div>
    </div>
    <div id="about" class="site-section">
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
          </div>
          <div class="col-md-12 col-lg-6 ml-auto">
            <img src="../../../public/theme/images/about.jpg" alt="Image" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
<!-- class -->
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
                $path="../../../".PATH_IMAGE."default_class.jpg";
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
      <!-- schedule -->
    </div>
    <div class="block-schedule overlay site-section" style="background-image: url('../../../public/theme/images/hero_bg_2.jpg');">
      <div class="container">
        <h2 id="schedule" class="text-white display-4 mb-5">Schedule</h2>
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
          <li class="nav-item">
            <a class="nav-link" id="pills-saturday-tab" data-toggle="pill" href="#pills-saturday" role="tab" aria-controls="pills-saturday" aria-selected="false">Saturday</a>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-sunday" role="tabpanel" aria-labelledby="pills-sunday-tab">
            <?php 
            while($row = $allSessionSun->fetch_assoc()) {
              if($row['day'] == "Sun"){ ?>
              <div class="row-wrap">
                <div class="row bg-white p-4 align-items-center">
                  <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5"><?php echo $row['class_name']?></h3></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span><?php echo $row['start_time']?> &mdash; <?php echo $row['end_time']?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> <?php echo ucfirst($row['trainer_name'])?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
                </div>
              </div>
            <?php }} ?> 
          </div>
       
          <div class="tab-pane fade show" id="pills-monday" role="tabpane1" aria-labelledby="pills-monday-tab">
          <?php  
          while($row = $allSessionMon->fetch_assoc()) { 
            if($row['day'] == "Mon"){?>
              <div class="row-wrap">
                <div class="row bg-white p-4 align-items-center">
                  <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5"><?php echo $row['class_name']?></h3></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span><?php echo $row['start_time']?> &mdash; <?php echo $row['end_time']?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> <?php echo ucfirst($row['trainer_name'])?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
                </div>
              </div> 
              <?php }} ?>
          </div>
       
          <div class="tab-pane fade show" id="pills-tuesday" role="tabpane1" aria-labelledby="pills-tuesday-tab">
          <?php  
          while($row = $allSessionTue->fetch_assoc()) {
           if($row['day'] == "Tue"){?>
              <div class="row-wrap">
                <div class="row bg-white p-4 align-items-center">
                  <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5"><?php echo $row['class_name']?></h3></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span><?php echo $row['start_time']?> &mdash; <?php echo $row['end_time']?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> <?php echo ucfirst($row['trainer_name'])?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
                </div>
                </div>
            <?php }} ?> 
          </div>
        
          <div class="tab-pane fade show" id="pills-wednesday" role="tabpane1" aria-labelledby="pills-wednesday-tab">
          <?php  while($row = $allSessionWed->fetch_assoc()) {
          if($row['day'] == "Wed"){ ?>
          <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5"><?php echo $row['class_name']?></h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span><?php echo $row['start_time']?> &mdash; <?php echo $row['end_time']?></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> <?php echo ucfirst($row['trainer_name'])?></div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <?php }} ?>
            </div>
           
          <div class="tab-pane fade show" id="pills-thursday" role="tabpanel" aria-labelledby="pills-thursday-tab">
          <?php  while($row = $allSessionThu->fetch_assoc()) {
          if($row['day'] == "Thu"){ ?>
          <div class="row-wrap">
              <div class="row bg-white p-4 align-items-center">
                <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5"><?php echo $row['class_name']?></h3></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span><?php echo $row['start_time']?> &mdash; <?php echo $row['end_time']?></div>
                <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> <?php echo ucfirst($row['trainer_name'])?></div>
                <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
              </div>
            </div>
            <?php }} ?>
            </div>
        
          <div class="tab-pane fade show" id="pills-friday" role="tabpanel" aria-labelledby="pills-friday-tab">
          <?php  
          while($row = $allSessionFri->fetch_assoc()) {
            if($row['day'] == "Fri"){ ?>
            <div class="row-wrap">
                <div class="row bg-white p-4 align-items-center">
                  <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5"><?php echo $row['class_name']?></h3></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span><?php echo $row['start_time']?> &mdash; <?php echo $row['end_time']?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> <?php echo ucfirst($row['trainer_name'])?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
                </div>
              </div>
              <?php } }?>
          </div>
        
          <div class="tab-pane fade show" id="pills-saturday" role="tabpanel" aria-labelledby="pills-saturday-tab">
          <?php  
          while($row = $allSessionSat->fetch_assoc()) { 
            if($row['day'] == "Sat"){ ?>
            <div class="row-wrap">
                <div class="row bg-white p-4 align-items-center">
                  <div class="col-sm-3 col-md-3 col-lg-3"><h3 class="h5"><?php echo $row['class_name']?></h3></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-clock-o mr-3"></span><?php echo $row['start_time']?> &mdash; <?php echo $row['end_time']?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3"><span class="icon-person mr-3"></span> <?php echo ucfirst($row['trainer_name'])?></div>
                  <div class="col-sm-3 col-md-3 col-lg-3 text-md-right"><a href="#" class="btn btn-primary pill px-4 mt-3 mt-md-0">Join Now</a></div>     
                </div>
              </div>
              <?php }} ?>
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
<!-- events -->
    <div class="site-section bg-light">
      <div class="container">
        <div class="heading-with-border">
          <h2 id="events" class="heading text-uppercase">Events & News</h2>
        </div>
        <div class="row mb-5">
        <?php 
          if(!$allEvents){
            die("Query DEAD ".mysqli_error($con));
          }

          while($row = $allEvents->fetch_assoc()) {
            
            if($row['image']==""){
                $path="../../../".PATH_IMAGE."default_event.jpg";
            } else {
                $path="../../../public/image/event_image/".$row['image'];                    
            }
          ?>  
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="post-entry bg-white">
              <div class="image">
                <img src=<?php echo $path; ?> alt="Image" class="img-fluid" width="345" height="230">
              </div>
              <div class="text p-4">
                <h2 class="h5 text-black"><a href="#"><?php echo $row['event_title']; ?></a></h2>
                <span class="text-uppercase date d-block mb-3"><small>At <?php echo $row['event_venue']; ?> &bullet; <?php echo $row['event_date']; ?></small></span>
                <p class="mb-0 event-test"><?php echo $row['event_description']; ?>.</p>
              </div>
            </div>
          </div>
          <?php } ?>  
        </div>
      </div>
    </div>
    <!-- contact us -->
    <div id="contact" class="site-section">
      <div class="container">
      <h2 class="text-black display-4">Contact Us</h2>  
        <div class="row">   
          <div class="col-md-12 col-lg-8 mb-5">  
            <form action="#" class="p-5">
              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="font-weight-bold" for="fullname">Full Name</label>
                  <input type="text" id="fullname" class="form-control" placeholder="Full Name">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="email">Email</label>
                  <input type="email" id="email" class="form-control" placeholder="Email Address">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="font-weight-bold" for="phone">Phone</label>
                  <input type="text" id="phone" class="form-control" placeholder="Phone #">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="message">Message</label> 
                  <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="Say hello to us"></textarea>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Send Message" class="btn btn-primary pill px-4 py-2">
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-4">
            <div class="p-4 mb-3">
              <h3 class="h5 mb-3">Contact Info</h3>
              <p class="mb-0 font-weight-bold">Address</p>
              <p class="mb-4">Hiru Fitness Centre Pvt.Ltd, 149, Bollatha, Ganemulla, Sri Lanka</p>

              <p class="mb-0 font-weight-bold">Phone</p>
              <p class="mb-4"><a href="tel://<?php echo BUSINESS_PHONE;?>"><?php echo BUSINESS_PHONE;?></a></p>

              <p class="mb-0 font-weight-bold">Email Address</p>
              <p class="mb-0"><a href="mailto:<?php echo BUSINESS_EMAIL?>?Subject=Contact%20Us" target="_top"><?php echo BUSINESS_EMAIL;?></a></p>
            </div> 
          </div>
        </div>
      </div>
    </div>
    <!-- including footer -->
    <?php include_once '../../layout/footer.php'; ?>