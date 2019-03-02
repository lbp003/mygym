<nav class="navbar navbar-inverse">
            <div class="container">          
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                     </button>
                    <div style="margin-top: 0; padding-bottom: 100px">
                    <a class="navbar-brand" href="../view/Dashboard.php" style="color: white;"><h2>Z Gym</h2></a>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        
                        <li style="padding-top: 15px; margin-top: 0px; font-size: 18px;"><a href="../view/notification.php" style="color: white"> Messages &nbsp;<span class="badge" id="badge"> 3 </span></a></li>
                        <li style="color: white; padding-top: 30px"> | &nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li style="padding-top: 30px; margin-top: 0px; font-size: 18px; color: white">
                          <?php                            
                                echo ucfirst($StaffDetails['staff_fname'])." ".ucfirst($StaffDetails['staff_lname']);
                            ?>
                        </li>&nbsp;&nbsp;
                        <li>
                            
                        <a href="../view/logout.php"><button type="button" class="btn btn-danger btn-sm navbar-btn">Log out</button></a>
                        </li>
                    </ul>
                    </div>
        
            </div>
</nav>