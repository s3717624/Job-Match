<?php
session_start();
require_once("php/account_class.php");
require_once("php/db_inc.php");
require_once("php/compose_class.php");

$Account = new Account();
$Message = new Message();


if(!(isset($_SESSION['user_id'])))
{
    if(isset($_SESSION['currentpage']))
        header("Location: ".$_SESSION['currentpage']);
    else
        header("Location: ./");
}

$_SESSION['currentpage'] = "compose.php";




?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Compose</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/compose.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/animated-headline.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<!-- ? Preloader Start -->

<!-- Preloader Start -->
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
                                        <li><a href="listing.php">Listings</a></li>
                                        <?php
                                        $add_job_text = "";
                                        $modified_link2 = "";

                                        if (isset($_SESSION["user_id"]))
                                        {
                                            $add_job_text = "Add job";
                                            $modified_link2 = "<a href='add_job.php'>";
                                            echo "<li>".$modified_link2.$add_job_text."</a></li>";
                                        }
                                        ?>
                                        <li><a href="categori.html">Categories</a></li>
                                        <li><a href="#">Pages</a>
                                            <ul class="submenu">
                                                <li><a href="about.html">about</a></li>
                                                <li><a href="blog.html">Blog</a></li>
                                                <li><a href="blog_details.html">Blog Details</a></li>
                                                <li><a href="elements.html">Element</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="inbox.php">Inbox</a></li>
                                        <li><a href="php/logging_out.php">Log out</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Header-btn -->
                            <div class="header-right-btn d-none d-lg-block ml-65">
                                <a href="add_job.php" class="border-btn">Post a Job</a>
                            </div>
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


                             
                             
                            

<!-- Hero Area Start-->
<div class="slider-area">
    <div class="single-slider slider-height d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-lg-8 messege-right p-3 border">
						<div class="row m-0">
							<div class="col-lg-12 bg-light text-white">
								<div class="row">
									<div class="col-lg-6">
										<h1 class="pt-2">New Message</h1>
									</div>
									
								</div>
							</div>
							<div class="col-lg-12 p-0 message-box-input">
								<form id="submit" name="submit" method="POST" action="#">
								  	<div class="form-group">
                                          <?php
                                          $user = $_SESSION['user_id'];

                                          if (isset($_REQUEST['replyto'])) {
                                            $replyto = $_REQUEST['replyto'];
                                            $user_from = $Account->getNameFromId($replyto);
                                            echo '<input readonly type="text" class="form-control" id="replyto"  value="<?php echo $user_from; ?>">';

                                            }else{

                                            $query = mysqli_query($conn, "SELECT * from applicants join jobs on applicants.job_id = jobs.job_id where employer_id = '15' ");

                                            

                                                ?> <select name='applicant'>; <?php
                                                // output data of each row
                                                while($row = $query->fetch_assoc()) {
                                                    $name = $Account->getFullNameFromId($row['account_id']);
                                                    
                                                  echo "<option value='" . $name . "'> ". $name ." </option>";
                                                }
                                                
                                            ?></select> <?php
                                            
                                            

                                        


                                            
                                        }
                                          
                                          ?>
								    	
								    	<input type="text" class="form-control" id="subject" name="subject"  placeholder="Subject">
								  		<textarea class="form-control" id="message" name="message" rows="6"></textarea>
								  	</div>
								 </form>
							</div>
							<div class="co-lg-12 message-box-last-content p-2">
                            
								<button type="submit" name="submit" form="submit" class="btn btn-primary btn-sm pl-3 pr-3">SEND</button>
								
							</div>
						</div>
					</div>

            </div>
        </div>

    </div>
</div>
        <!-- footer-bottom area -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="footer-border">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-12 ">
                            <div class="footer-copy-right text-center">
                                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End-->
    </div>
</footer>

<!-- Scroll Up -->
<div id="back-top" >
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
</div>

<!-- JS here -->

<script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
<!-- Jquery, Popper, Bootstrap -->
<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="./assets/js/popper.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<!-- Jquery Mobile Menu -->
<script src="./assets/js/jquery.slicknav.min.js"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="./assets/js/owl.carousel.min.js"></script>
<script src="./assets/js/slick.min.js"></script>
<!-- One Page, Animated-HeadLin -->
<script src="./assets/js/wow.min.js"></script>
<script src="./assets/js/animated.headline.js"></script>
<script src="./assets/js/jquery.magnific-popup.js"></script>

<!-- Date Picker -->
<script src="./assets/js/gijgo.min.js"></script>
<!-- Nice-select, sticky -->
<script src="./assets/js/jquery.nice-select.min.js"></script>
<script src="./assets/js/jquery.sticky.js"></script>
<!-- Progress -->
<script src="./assets/js/jquery.barfiller.js"></script>

<!-- counter , waypoint,Hover Direction -->
<script src="./assets/js/jquery.counterup.min.js"></script>
<script src="./assets/js/waypoints.min.js"></script>
<script src="./assets/js/jquery.countdown.min.js"></script>
<script src="./assets/js/hover-direction-snake.min.js"></script>

<!-- contact js -->
<script src="./assets/js/contact.js"></script>
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/jquery.validate.min.js"></script>
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>

</body>
</html>

<?php

if (isset($_POST['submit'])) {
    
    $Message->send_message($replyto, $_POST['subject'], $_POST['message']);
}
?>