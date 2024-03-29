<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand h1 mb-0 h1 ml-3" href="#"><?php echo strtoupper(SYSTEM_BUSINESS_NAME);?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="far fa-user"></i>
        <?php echo ucfirst($user['first_name'])." ".ucfirst($user['last_name']); ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../index/profile.php">My Profile</a>
          <a class="dropdown-item" href="../index/change-pw.php">Change Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../index/logout.php">Log Out</a>
        </div>
      </li>
    </ul>
  </div>
</nav>