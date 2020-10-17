<?php
session_start();
require_once("php/account_class.php");
require_once("php/job_class.php");
require_once("php/db_inc.php");

$Account = new Account();
$Job = new Job();

//if(!(isset($_SESSION['user_id'])))
//{
//    header($_SESSION['currentpage']);
//}

$link = $conn = mysqli_connect("localhost", "outsideadmin", "bLb$?Se%@6@U*5CK", "login_system");

if(!isset($_SESSION['user_id']))
{
    if (isset($_SESSION['currentpage']))
        header("Location: " . $_SESSION['currentpage']);
    else
        header("Location: ./");
}
$userid = $_SESSION['user_id'];
$row_cnt = mysqli_num_rows($Job->matchJobs($_SESSION['user_id']));
$alljobs = mysqli_query($conn,"SELECT * FROM jobs WHERE employer_id = $userid");
$def_cnt = mysqli_num_rows($alljobs);


if(isset($_SESSION['user_id']))
{
    if (!($Account->typeCheck($_SESSION['user_id']) == "employers"))
    {
        if (isset($_SESSION['currentpage']))
            header("Location: " . $_SESSION['currentpage']);
        else
            header("Location: ./");
    }
}

$_SESSION['currentpage'] = 'joblist.php';

$count = 0;

$checked1 = $checked2 = $checked3 = $checked4 = $checked5 = null;

$lowerprice = 0;
$upperprice = 999999999;

if(isset($_GET['pricerange']))
{
    if($_GET['pricerange'] == "50korless")
    {
        $upperprice = 50000;
    } else if ($_GET['pricerange'] == "50kto75k")
    {
        $lowerprice = 50000;
        $upperprice = 75000;
    } else if ($_GET['pricerange'] == "75kto100k")
    {
        $lowerprice = 75000;
        $upperprice = 100000;
    } else if ($_GET['pricerange'] == "100kto125k")
    {
        $lowerprice = 100000;
        $upperprice = 125000;
    } else if ($_GET['pricerange'] == "125kormore")
    {
        $lowerprice = 125000;
    }
}

$nature1 = $nature2 = $nature3 = null;

$jobnature = null;

if(isset($_GET['jobnature']))
{
    if($_GET['jobnature'] == "fulltime")
    {
        $jobnature = "Full time";
    } else if($_GET['jobnature'] == "parttime")
    {
        $jobnature = "Part time";
    } else if($_GET['jobnature'] == "casual")
    {
        $jobnature = "Casual";
    }
}

if(isset($_GET['searchfield']))
{
    $searchfield = $_GET['searchfield'];
}

if(isset($_GET['search_query']))
{
    $searchfield = $_GET['search_query'];
}
?>


<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Job Match - Listing</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
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
<!--    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>-->
    <!-- Preloader Start -->
    <?php include_once("header.php") ?>
    <main>
        <!--? Hero Area Start-->
        <div class="slider-area hero-bg2 hero-overly">
            <div class="single-slider hero-overly  slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10 col-lg-10">
                            <!-- Hero Caption -->
                            <div class="hero__caption hero__caption2 pt-200">
                                <h1>Your job listings</h1>
                                <h2 class="text-light">Click one to view applicants</h2>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- listing Area Start -->
        <div class="listing-area pt-120 pb-120">
            <div class="container d-flex justify-content-center">
                <div class="row">
                    <!--? Left content -->
                    
                        
                        <!-- Job Category Listing End -->
                    </div>
                    <!--?  Right content -->
                    <div class="col-xl-8 col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-12">

                            
                                <div class="count mb-35">
                                    <span><?php
                                            echo $def_cnt;
                                            echo " Listing(s) are available";
                                        ?> </span>
                                </div>
                            </div>
                        </div>
                        <!--? Popular Directory Start -->
                        <div class="popular-directorya-area fix">
                            <div class="row">
                                
                                <?php 
                                while($row = mysqli_fetch_assoc($alljobs))
                                {
                                ?>

                                <div class="col-lg-6">
                                    <!-- Single -->
                                    <div class="properties properties2 mb-30">
                                        <div class="properties__card">
                                            <div class="properties__img overlay1">
                                                <a href="#"><img src="assets/img/gallery/properties1.png" alt=""></a>
                                                <div class="img-text">
                                                    
                                                </div>
                                                <div class="icon">
                                                    <img src="assets/img/gallery/categori_icon1.png" alt=""> 
                                                </div>
                                            </div>
                                            <div class="properties__caption">
                                                <h3><a href="applicants.php?jobid=<?php echo $row['job_id'];?>"><?php echo $row['job_name'];?></a></h3>
                                                <p><?php echo $row['job_short_desc'];?></p>
                                            </div>
                                            <div class="properties__footer d-flex justify-content-between align-items-center">
                                                <div class="restaurant-name">
                                                    <img src="assets/img/gallery/restaurant-icon.png" alt="">
                                                    <h3>$<?php echo $row['job_salary'];?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php 
                                }
                                ?>

                                
                            </div>
                        </div>
                        <!--? Popular Directory End -->
                        <!--Pagination Start  -->
                        <div class="pagination-area text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Pagination End  -->
                    </div>
                </div>
            </div>
        </div>
        <!-- listing-area Area End -->
        <!--? Want To work 02-->
        <section class="wantToWork-area">
            <div class="container">
                <div class="wants-wrapper w-padding2">
                    <div class="row justify-content-between">
                        <div class="col-xl-8 col-lg-8 col-md-7">
                            <div class="wantToWork-caption wantToWork-caption2">
                                <img src="assets/img/logo/logo2_footer.png" alt="" class="mb-20">
                                <p>Users and submit their own items. You can create different packages and by connecting with your
                                PayPal or Stripe account charge users for registration to your directory portal.</p>
                            </div>
                        </div>
                        <!-- <div class="col-xl-4 col-lg-4 col-md-5">
                            <div class="footer-social f-right sm-left">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="https://bit.ly/sai4ull"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </section>
        <!-- Want To work End -->
        <!--? Want To work 01-->
        <section class="wantToWork-area">
            <div class="container">
                <div class="wants-wrapper">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-xl-7 col-lg-9 col-md-8">
                            <div class="wantToWork-caption wantToWork-caption2">
                                <div class="main-menu2">
                                    <nav>
                                        <ul>
                                            <li><a href="index.php">Home</a></li>
                                            <li><a href="explore.html">Explore</a></li> 
                                            <li><a href="pages.html">Pages</a></li>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="contact.html">Contact</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <!-- Want To work End -->
    </main>
    <footer>
        <div class="footer-wrapper pt-30">
            <!-- footer-bottom -->
            <div class="footer-bottom-area">
                <div class="container">
                    <div class="footer-border">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-xl-10 col-lg-9 ">
                                <div class="footer-copy-right">
                                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                      Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                                      <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
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