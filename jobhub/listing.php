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

$row_cnt = mysqli_num_rows($Job->matchJobs($_SESSION['user_id']));
$alljobs = mysqli_query($conn,"SELECT * FROM jobs");
$def_cnt = mysqli_num_rows($alljobs);


if(isset($_SESSION['user_id']))
{
    if (!($Account->typeCheck($_SESSION['user_id']) == "applicants"))
    {
        if (isset($_SESSION['currentpage']))
            header("Location: " . $_SESSION['currentpage']);
        else
            header("Location: ./");
    }
}

$_SESSION['currentpage'] = './listing.php';

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
                                <h1>Explore what you are finding</h1>
                            </div>
                            <!--Hero form -->
                            <form id="jobsearch" action="listing.php" class="search-box mb-100" method="GET">
                                <div class="input-form">
                                    <input type="text" name="search_query" placeholder="What are you finding?">
                                </div>
                                <div class="select-form">
                                    <div class="select-itms">
                                        <select name="select" id="select1">
                                            <option value="">In where?</option>
                                            <option value="">Catagories One</option>
                                            <option value="">Catagories Two</option>
                                            <option value="">Catagories Three</option>
                                            <option value="">Catagories Four</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="search-form">
                                    <a href="#" onclick="document.getElementById('jobsearch').submit()"><i class="ti-search"></i> Search</a>
                                </div>	
                            </form>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- listing Area Start -->
        <div class="listing-area pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <!--? Left content -->
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="small-section-tittle2 mb-45">
                                    <h4>Advanced Filter</h4>
                                </div>
                            </div>
                        </div>
                        <!-- Job Category Listing start -->
                        <div class="category-listing mb-50">
                            <form action="./listing.php" method="GET" id="advancedfilter">
                            <!-- single one -->
                            <div class="single-listing">
                                <!-- Select City items start -->
<!--                                <div class="select-job-items2">-->
<!--                                    <select name="select2">-->
<!--                                        <option value="" disabled selected>City</option>-->
<!--                                        <option value="">Dhaka</option>-->
<!--                                        <option value="">india</option>-->
<!--                                        <option value="">UK</option>-->
<!--                                        <option value="">US</option>-->
<!--                                        <option value="">Pakistan</option>-->
<!--                                    </select>-->
<!--                                </div>-->
                                <!--  Select City items End-->
                                <!-- Select State items start -->
<!--                                <div class="select-job-items2">-->
<!--                                    <select name="select2">-->
<!--                                        <option value="" disabled selected>State</option>-->
<!--                                        <option value="">Dhaka</option>-->
<!--                                        <option value="">Mirpur</option>-->
<!--                                        <option value="">Danmondi</option>-->
<!--                                        <option value="">Rampura</option>-->
<!--                                        <option value="">Htizill</option>-->
<!--                                    </select>-->
<!--                                </div>-->
                                <!--  Select State items End-->
                                <!-- Select km items start -->
<!--                                <div class="select-job-items2">-->
<!--                                    <select name="select2">-->
<!--                                        <option value="">Near 1 km</option>-->
<!--                                        <option value="">2 km</option>-->
<!--                                        <option value="">3 km</option>-->
<!--                                        <option value="">4 km</option>-->
<!--                                        <option value="">5 km</option>-->
<!--                                        <option value="">6 km</option>-->
<!--                                    </select>-->
<!--                                </div>-->
                                <!--  Select km items End-->
                                <!-- select-Categories start -->
                                <div class="select-Categories pt-80 pb-30">
                                    <div class="small-section-tittle2 mb-20">
                                        <h4>Price range</h4>
                                    </div>
                                    <?php
                                        if(isset($_GET['pricerange']))
                                        {
                                            if($_GET['pricerange'] == '50korless')
                                            {
                                                $checked1 = "checked";
                                            } else if($_GET['pricerange'] == '50kto75k')
                                            {
                                                $checked2 = "checked";
                                            } else if($_GET['pricerange'] == '75kto100k')
                                            {
                                                $checked3 = "checked";
                                            } else if($_GET['pricerange'] == '100kto125k')
                                            {
                                                $checked4 = "checked";
                                            } else if($_GET['pricerange'] == '125kormore')
                                            {
                                                $checked5 = "checked";
                                            }
                                        }

                                    echo "<label>
                                        <input type='radio' name='pricerange' value='50korless' onclick='' " . $checked1 . ">
                                            $50K or less
                                        </label><br>
                                    <label>
                                        <input type='radio' name='pricerange' value='50kto75k' onclick='' " . $checked2 . ">
                                            $50K-75K
                                        </label><br>
                                    <label>
                                        <input type='radio' name='pricerange' value='75kto100k' onclick='' " . $checked3 . ">
                                            $75K-100K
                                        </label><br>
                                    <label>
                                        <input type='radio' name='pricerange' value='100kto125k' onclick='' " . $checked4 . ">
                                            $100K-125K
                                        </label><br>
                                    <label>
                                        <input type='radio' name='pricerange' value='125kormore' onclick='' " . $checked5 . ">
                                            $125K or more
                                        </label><br>
                                        ";

//                                        echo "Test: ".$lowerprice." ".$upperprice;
                                    ?>

                                    <script language="JavaScript">

                                    </script>
                                </div>
                                <!-- select-Categories End -->
                                <!-- select-Categories start -->

                                <h4>Job nature</h4>
                                <?php
                                if(isset($_GET['jobnature']))
                                {
                                    if($_GET['jobnature'] == 'fulltime')
                                    {
                                        $nature1 = "checked";
                                    } else if($_GET['jobnature'] == 'parttime')
                                    {
                                        $nature2 = "checked";
                                    } else if($_GET['jobnature'] == 'casual')
                                    {
                                        $nature3 = "checked";
                                    }
                                }

                                echo "<label>
                                        <input type='radio' name='jobnature' value='fulltime' onclick='' " . $nature1 . ">
                                            Full time
                                        </label><br>
                                    <label>
                                        <input type='radio' name='jobnature' value='parttime' onclick='' " . $nature2 . ">
                                            Part time
                                        </label><br>
                                    <label>
                                        <input type='radio' name='jobnature' value='casual' onclick='' " . $nature3 . ">
                                            Casual
                                        </label><br>      
                                        ";

//                                echo  "Test: ".$jobnature;
                                ?><br>

                                <?php
                                if(isset($searchfield))
                                {
                                    echo "<input type=\"hidden\" id=\"searchfield\" name=\"searchfield\" value=".$searchfield.">";
                                }
                                ?>
                                <input type="submit" name="gobtn" id="gobtn" value="Go">
                                <!-- select-Categories End -->
                            </form>
                            </div>
                        </div>
                        <!-- Job Category Listing End -->
                    </div>
                    <!--?  Right content -->
                    <div class="col-xl-8 col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-12">
                            <form action="listing.php" name="alljobsform" method="get">
                                <input class ="page-link" type="submit" id ="alljobsbtn" name="alljobsbtn" value="Show all jobs">
                            </form>

                            <form action="listing.php" name="matchform"method="get">
                                <input class ="page-link" type="submit" id ="matchbtn" name="matchbtn" value="Match jobs">
                            </form>

                            
                                <div class="count mb-35">
                                    <span><?php
                                        if(isset($_GET['search_query'])){
                                            $results = $Job->searchJob($_GET['search_query']);

                                            if(mysqli_num_rows($results)>0)
                                            {
                                                while($row = mysqli_fetch_assoc($results))
                                                {
                                                    $jobsalary1 = $row['job_salary'];
                                                    $jobsalary2 = str_replace(',', '', $jobsalary1);

                                                    if(!($upperprice > $jobsalary2 && $jobsalary2 > $lowerprice))
                                                    {
                                                        continue;
                                                    }
                                                    if(isset($jobnature))
                                                    {
                                                        if(!($row['job_nature'] == $jobnature))
                                                        {
                                                            continue;
                                                        }
                                                    }
                                                    $count++;
                                                }
                                            }
                                            echo $count;
                                            echo " Listing(s) are available";
                                        } 
                                        elseif(isset($_GET['alljobsbtn'])){
                                            echo $def_cnt;
                                            echo " Listing(s) are available";
                                        }
                                        elseif(isset($_GET['gobtn'])) 
                                        {
                                            if(isset($searchfield))
                                                $results = $Job->searchJob($searchfield);
                                            else
                                                $results = $Job->searchJob("");

                                            if(mysqli_num_rows($results)>0)
                                            {
                                                while($row = mysqli_fetch_assoc($results))
                                                {
                                                    $jobsalary1 = $row['job_salary'];
                                                    $jobsalary2 = str_replace(',', '', $jobsalary1);

                                                    if(!($upperprice > $jobsalary2 && $jobsalary2 > $lowerprice))
                                                    {
                                                        continue;
                                                    }
                                                    if(isset($jobnature))
                                                    {
                                                        if(!($row['job_nature'] == $jobnature))
                                                        {
                                                            continue;
                                                        }
                                                    }
                                                    $count++;
                                                }
                                            }

                                            echo $count;
                                            echo " Match(es) founds";
                                        }else{
                                            echo $row_cnt;
                                            echo " Match(es) founds";
                                        }
                                        ?> </span>
                                </div>
                            </div>
                        </div>
                        <!--? Popular Directory Start -->
                        <div class="popular-directorya-area fix">
                            <div class="row">
                                <?php

                                $ret = $Job->matchJobs($_SESSION['user_id']);
                                $cnt=1;
                                

                                /* show searched code */
                                if(isset($_GET['search_query']) || isset($searchfield))
                                {
                                    if(isset($_GET['search_query']))
                                        $results = $Job->searchJob($_GET['search_query']);
                                    else
                                        $results = $Job->searchJob($searchfield);
//                                    echo $_POST['search_query'].'<br>';
//                                    echo "testing";

                                    if(mysqli_num_rows($results)>0)
                                    {
                                        while($row = mysqli_fetch_assoc($results))
                                        {
                                            $jobsalary1 = $row['job_salary'];
                                            $jobsalary2 = str_replace(',', '', $jobsalary1);

                                            if(!($upperprice > $jobsalary2 && $jobsalary2 > $lowerprice))
                                            {
                                                continue;
                                            }
                                            if(isset($jobnature))
                                            {
                                                if(!($row['job_nature'] == $jobnature))
                                                {
                                                    continue;
                                                }
                                            }
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
                                                            <h3><a href="job_details.php?jobid=<?php echo $row['job_id'];?>"><?php echo $row['job_name'];?></a></h3>
                                                            <p><?php echo $row['job_short_desc'];?></p>
                                                        </div>
                                                        <div class="properties__footer d-flex justify-content-between align-items-center">
                                                            <div class="restaurant-name">
                                                                <img src="assets/img/gallery/restaurant-icon.png" alt="">
                                                                <h3>$<?php echo $row['job_salary'];?></h3>
                                                            </div>
                                                            <div class="heart">
                                                                <img src="assets/img/gallery/heart1.png" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $count++;
                                        }
                                    }
                                }

                                elseif(isset($_GET['alljobsbtn'])) {
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
                                                <h3><a href="job_details.php?jobid=<?php echo $row['job_id'];?>"><?php echo $row['job_name'];?></a></h3>
                                                <p><?php echo $row['job_short_desc'];?></p>
                                            </div>
                                            <div class="properties__footer d-flex justify-content-between align-items-center">
                                                <div class="restaurant-name">
                                                    <img src="assets/img/gallery/restaurant-icon.png" alt="">
                                                    <h3>$<?php echo $row['job_salary'];?></h3>
                                                </div>
                                                <div class="heart">
                                                    <img src="assets/img/gallery/heart1.png" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php $cnt=$cnt+1; 
                                }
                                }

                                elseif(isset($_GET['matchbtn'])) {
                                    while($row = mysqli_fetch_assoc($ret))
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
                                                <h3><a href="job_details.php?jobid=<?php echo $row['job_id'];?>"><?php echo $row['job_name'];?></a></h3>
                                                <p><?php echo $row['job_short_desc'];?></p>
                                            </div>
                                            <div class="properties__footer d-flex justify-content-between align-items-center">
                                                <div class="restaurant-name">
                                                    <img src="assets/img/gallery/restaurant-icon.png" alt="">
                                                    <h3>$<?php echo $row['job_salary'];?></h3>
                                                </div>
                                                <div class="heart">
                                                    <img src="assets/img/gallery/heart1.png" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php $cnt=$cnt+1; 
                                }
                                }
                                /* show matched code */
                                else
                                while($row = mysqli_fetch_assoc($alljobs))
                                {
                                    $jobsalary1 = $row['job_salary'];
                                    $jobsalary2 = str_replace(',', '', $jobsalary1);

                                    if(!($upperprice > $jobsalary2 && $jobsalary2 > $lowerprice))
                                    {
                                        continue;
                                    }
                                    if(isset($jobnature))
                                    {
                                        if(!($row['job_nature'] == $jobnature))
                                        {
                                            continue;
                                        }
                                    }
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
                                                <h3><a href="job_details.php?jobid=<?php echo $row['job_id'];?>"><?php echo $row['job_name'];?></a></h3>
                                                <p><?php echo $row['job_short_desc'];?></p>
                                            </div>
                                            <div class="properties__footer d-flex justify-content-between align-items-center">
                                                <div class="restaurant-name">
                                                    <img src="assets/img/gallery/restaurant-icon.png" alt="">
                                                    <h3>$<?php echo $row['job_salary'];?></h3>
                                                </div>
                                                <div class="heart">
                                                    <img src="assets/img/gallery/heart1.png" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php $cnt=$cnt+1; }?>
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
                        <div class="col-xl-4 col-lg-4 col-md-5">
                            <div class="footer-social f-right sm-left">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="https://bit.ly/sai4ull"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
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