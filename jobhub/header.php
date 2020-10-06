<header>
        <!-- Header Start -->
        <div class="header-area header-transparent">
            <div class="main-header ">
                <div class="header-bottom  header-sticky">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-2">
                                <div class="logo">
                                    <a href="index.php"><img src="assets/img/logo/logo.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-10">
                                <div class="menu-wrapper  d-flex align-items-center justify-content-end">
                                    <!-- Main-menu -->
                                    <div class="main-menu d-none d-lg-block">
                                        <nav>
                                            <ul id="navigation">                                                                                          
                                                <li><a href="index.php">Home</a></li>
                                                
                                                <?php
                                                $add_job_text = "";
                                                $modified_link2 = "";

                                                if (isset($_SESSION["user_id"]) && ($Account->typeCheck($_SESSION['user_id'])) == 'employers')
                                                {
                                                    $add_job_text = "Add job";
                                                    $modified_link2 = "<a href='add_job.php'>";
                                                    echo "<li>".$modified_link2.$add_job_text."</a></li>";
                                                    echo "<li><a href='joblist.php'>Your Listings</a></li>";
                                                    
                                                }else{
                                                    echo '<li><a href="listing.php">Listings</a></li>';
                                                }
                                                ?>
                                                <li><?php
                                                    $login_text = "Log in";
                                                    $modified_link = "<a href='login.php'>";

                                                    if (isset($_SESSION["user_id"]))
                                                    {
                                                        $login_text = "Profile";
                                                        $modified_link = "<a href='profile.php'>";
                                                        echo "<li><a href='inbox.php'>Inbox</a></li>";
                                                        
                                                    }
                                                    ?> <?php echo $modified_link.$login_text."</a></li>"; ?>

                                                    <?php


                                                    if (isset($_SESSION["user_id"]))
                                                    {
                                                        
                                                        echo '<li><a href="php/logging_out.php">Log out</a></li>';
                                                        
                                                    }
                                                    ?>
                                                    
                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- Header-btn -->
                                    
                                </div>
                            </div> 
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <!-- header end -->