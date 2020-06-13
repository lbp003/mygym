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
              <a href="#" target="_blank" class="p-2 pl-0"><span class="icon-facebook"></span></a>
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
    <div class="site-navbar-wrap bg-white">  
    <div class="container">
        <div class="site-navbar bg-light">
        <div class="py-1">
            <div class="row align-items-center">
            <div class="col-4">
                <h2 class="mb-0 site-logo"><a href="index.php"><strong>HIRU</strong> FITNESS CENTER</a></h2>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>  
    <div class="Container-fluid">
      <div class="row">
          <div class="col-md-12">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Thank you for getting in touch!.</h1>
                    <p class="lead">We appreciate you contacting <?php echo SYSTEM_BUSINESS_NAME ?>. One of our colleagues will get back in touch with you soon! <br />
                    Stay Fit!.</p>
                </div>
            </div>
          </div>
      </div>
    </div>
    <!-- including footer -->
    <?php include_once '../../layout/footer.php'; ?>