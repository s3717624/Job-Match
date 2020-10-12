<?php
session_start();
require_once("php/job_class.php");
require_once("php/account_class.php");
require_once("php/company_class.php");
require_once("php/db_inc.php");

$Account = new Account();

//if(!(isset($_SESSION['job_id'])))
//{
//    header("Location: ".$_SESSION['currentpage']);
//}


//if(isset($_SESSION['job_id']))
//    header($_SESSION['currentpage']);

//$jobid = $_SESSION["jobid"];
//$job = new Job();
//$company = new Company();
//$jobname = $job.getName();
//$jobshortdesc = $job.getShortDesc();
//$jobdesc = $job.getDesc();
//$jobskills = $job.getSkills();
//$jobeducation = $job.getEducation();
//$jobposted = $job.getPostedDate();
//$joblocation = $job.getLocation();
//$jobnature = $job.getNature();
//$jobsalary = $job.getSalary();
//$jobapply = $job.getApplyDate();

$conn = mysqli_connect("localhost", "outsideadmin", "bLb$?Se%@6@U*5CK", "login_system");
$appid = $_REQUEST['appid'];
$appinfo = mysqli_query($conn,"SELECT * FROM applicants WHERE app_id = $appid");
$row = mysqli_fetch_array($appinfo);
$cover = $row['cover_letter'];
$name = $row['app_name'];
$skills = $row['app_skills'];
$edu = $row['app_education'];
$phone = $row['app_phone'];
$email = $row['app_email'];
$jobid = $row['job_id'];
$appdate = date( 'd/m/Y h:i:s', strtotime($row['apply_date']));
$jobinfo = mysqli_query($conn,"SELECT * FROM jobs WHERE job_id = $jobid");
$jobarr = mysqli_fetch_array($jobinfo);
$jobname = $jobarr['job_name'];

$_SESSION['currentpage'] = "app_details.php?appid=$appid";


?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Job board | Template</title>
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
<!--    <div id="preloader-active">-->
<!--        <div class="preloader d-flex align-items-center justify-content-center">-->
<!--            <div class="preloader-inner position-relative">-->
<!--                <div class="preloader-circle"></div>-->
<!--                <div class="preloader-img pere-text">-->
<!--                    <img src="assets/img/logo/loder.png" alt="">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!-- Preloader Start -->
    <?php include_once("header.php") ?>
    <main>
        <!-- Hero Area Start-->
        <div class="slider-area2">
            <div class="single-slider slider-height3 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-9">
                            <!-- Hero Caption -->
                            <div class="hero__caption hero__caption2">
                                <h1>Application for <?php echo $jobname ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Hero Area End-->
        <!-- job post company Start -->
        <div class="job-post-company pt-120 pb-120">
            <div class="container">
                <div class="row justify-content-between">
                    <!-- Left Content -->
                    <div class="col-xl-7 col-lg-8">
                        <!-- Single -->

                        <div class="job-post-details">
                            <div class="post-details1 mb-50">
                                <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Cover Letter</h4>
                                </div>
                                <p><?php echo $cover; ?></p>
                            </div>
                            <div class="post-details2  mb-50">
                                <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Knowledge, Skills, and Abilities</h4>
                                </div>
                                <ul>
                                    <?php echo "<li>$skills</li>"?>
                                </ul>
                            </div>
                            <div class="post-details2  mb-50">
                                <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Education + Experience</h4>
                                </div>
                                <ul>
                                    <?php echo "<li>$edu</li>"?>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- Right Content -->
                    <div class="col-xl-4 col-lg-4">
                        <div class="post-details3  mb-50">
                            <!-- Small Section Tittle -->
                            <div class="small-section-tittle">
                                <h4>Job Overview</h4>
                            </div>
                            <ul>
                                <li>Applied on : <span><?php echo $appdate; ?></span></li>
                                <li>Applicant name : <span><?php echo $name; ?></span></li>
                                <li>Applicant phone number : <span><?php echo $phone; ?></span></li>
                                <li>Email :  <span><?php echo $email; ?></span></li>
                            </ul>
                            <div class="apply-btn2">
                                <?php
                                $query = mysqli_query($conn,"SELECT account_id FROM applicants WHERE app_id = $appid");
                                
                                $row = mysqli_fetch_array($query);
                                $acc_id = $row['account_id'];                 
                                ?>
                                <a href="compose.php?replyto=<?php echo $acc_id ?>" class="btn">Contact</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- job post company End -->
    </main>
    <footer>
        <div class="footer-wrappper pl-100 pr-100 section-bg" data-background="assets/img/gallery/footer-bg.png">
           <!-- Footer Start-->
           <div class="footer-area footer-padding">
               <div class="container-fluid">
                   <div class="row">
                       <div class="col-xl-3 col-lg-5 col-md-4 col-sm-6">
                           <div class="single-footer-caption mb-50">
                               <div class="single-footer-caption mb-30">
                                   <!-- logo -->
                                   <div class="footer-logo mb-25">
                                       <a href="index.php"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
                                   </div>
                                   <div class="footer-tittle">
                                       <div class="footer-pera">
                                           <p>The automated process starts as  soon as your clothes go into the machine.</p>
                                       </div>
                                   </div>
                                   <!-- social -->
                                   <div class="footer-social">
                                       <a href="#"><i class="fab fa-twitter"></i></a>
                                       <a href="https://bit.ly/sai4ull"><i class="fab fa-facebook-f"></i></a>
                                       <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5">
                           <div class="single-footer-caption mb-50">
                               <div class="footer-tittle">
                                   <h4>Top categories</h4>
                                   <ul>
                                       <li><a href="#">Design & creatives</a></li>
                                       <li><a href="#">Telecommunication</a></li>
                                       <li><a href="#">Restaurant</a></li>
                                       <li><a href="#">Programing</a></li>
                                       <li><a href="#">Architecture</a></li>
                                   </ul>
                               </div>
                           </div>
                       </div>
                       <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                           <div class="single-footer-caption mb-50">
                               <div class="footer-tittle">
                                   <h4>For employer</h4>
                                   <ul>
                                       <li><a href="#">Design & creatives</a></li>
                                       <li><a href="#">Telecommunication</a></li>
                                       <li><a href="#">Restaurant</a></li>
                                       <li><a href="#">Programing</a></li>
                                       <li><a href="#">Architecture</a></li>
                                   </ul>
                               </div>
                           </div>
                       </div>
                       <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                           <div class="single-footer-caption mb-50">
                               <div class="footer-tittle">
                                   <h4>Company</h4>
                                   <ul>
                                       <li><a href="#">Design & creatives</a></li>
                                       <li><a href="#">Telecommunication</a></li>
                                       <li><a href="#">Restaurant</a></li>
                                       <li><a href="#">Programing</a></li>
                                       <li><a href="#">Architecture</a></li>
                                   </ul>
                               </div>
                           </div>
                       </div>
                       <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                           <div class="single-footer-caption mb-50">
                               <div class="footer-tittle mb-50">
                                   <h4>Subscribe newsletter</h4>
                                   <p>Subscribe newsletter to get updates.</p>
                               </div>
                               <!-- Form -->
                               <div class="footer-form" >
                                   <div id="mc_embed_signup">
                                       <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                                       method="get" class="subscribe_form relative mail_part">
                                       <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address"
                                       class="placeholder hide-on-focus" onfocus="this.placeholder = ''"
                                       onblur="this.placeholder = ' Email Address '">
                                       <div class="form-icon">
                                           <button type="submit" name="submit" id="newsletter-submit"
                                           class="email_icon newsletter-submit button-contactForm"><img src="assets/img/gallery/form.png" alt=""></button>
                                       </div>
                                       <div class="mt-10 info"></div>
                                   </form>
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