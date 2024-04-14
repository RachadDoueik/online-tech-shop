<?php
require_once '../helpers/connection.php';
session_start();
if (isset($_SESSION) && isset($_SESSION['user'])) {
  header("Location:home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TechZone</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../css/indexvicon.png" rel="icon">
  <link href="../css/indexple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- font awesome style -->
  <link href="../css/index-font-awesome.min.css" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="../css/index/aos/aos.css" rel="stylesheet">
  <link href="../css/index/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/index/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../css/index/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../css/index/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../css/index/remixicon/remixicon.css" rel="stylesheet">
  <link href="../css/index/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../css/index-style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: OnePage
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top shadow-sm">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo text-dark fw-bolder"><a href="index.php">TechZone</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="../css/indexgo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active fw-bolder text-dark" href="home.php">Home</a></li>
          <li><a class="nav-link scrollto" href="#">About</a></li>
          <li><a class="nav-link scrollto" href="login.php">Login</a></li>
          <li><a class="getstarted scrollto bg-primary" href="register.php">Create Account</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center" style="background-image:url(../images/Macbook\ Air\ M2.jpeg);">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9 text-center">
          <h1 class="text-dark">Welcome to Techzone</h1>
          <h2>The only tech shop you'l ever need</h2>
        </div>
      </div>
      <div class="text-center">
        <a href="login.php" class="btn-get-started scrollto bg-primary">Get Started</a>
      </div>

      <div class="row icon-boxes">
        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
          <div class="icon-box">
            <div class="icon"><i class="ri-macbook-line"></i></div>
            <h4 class="title"><a href="">Laptops</a></h4>
            <p class="description">A Wide Set of Laptops,so Mobility, Productivity and Entertainment can be Everywhere..For Everyone </p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="300">
          <div class="icon-box">
            <div class="icon"><i class="ri-computer-line"></i></div>
            <h4 class="title"><a href="">Desktop Computers</a></h4>
            <p class="description">No Matter What is your task, our Desktop PC Machines will never let you down</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="400">
          <div class="icon-box">
            <div class="icon"><i class="ri-smartphone-line"></i></div>
            <h4 class="title"><a href="">Smartphones</a></h4>
            <p class="description">We Have Budget, Midrange and Flagship Smartphones For every Use and Every Need</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="500">
          <div class="icon-box">
            <div class="icon"><i class="ri-headphone-line"></i></div>
            <h4 class="title"><a href="">Gadgets</a></h4>
            <p class="description">Who Doesn't Love Noise Cancellation and A fully Charged Phone All time? Don't miss out our great gadgets </p>
          </div>
        </div>

      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= Counts Section ======= -->
    <!-- End Counts Section -->

    <!-- ======= About Video Section ======= -->
    <section id="about-video" class="about-video">
      <div class="container" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-6 video-box align-self-baseline" data-aos="fade-right" data-aos-delay="100">
            <img src="../images/info.gif" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 pt-3 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
            <h3>What is TechZone? It's simply online shopping, Combined with a lot of Tech for day to day use. </h3>
            <p class="fst-italic">
              we try to offer a better experience with online shopping by:
            </p>
            <ul>
              <li><i class="bx bx-check-double"></i>Providing Products with Premium Quality</li>
              <li><i class="bx bx-check-double"></i>Giving Customers the needed Privacy with our Secure Platform</li>
              <li><i class="bx bx-check-double"></i>Staying up to date to every News and Changes in the Tech Industry</li>
            </ul>
            <p>
              We are a small buisness with a lot of potential.On a mission to be a gamechanger in the tech market worldwide, we try to
              put all our experiences within the commerce field, so that goal is always verified and guaranteed.
            </p>
          </div>

        </div>

      </div>
    </section><!-- End About Video Section -->

    <!-- ======= Brands Section ======= -->
    <section id="clients" class="clients section-bg">
      <div class="container">

        <div class="row">

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center" data-aos="zoom-in">
            <img src="../images/brands/asus.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center" data-aos="zoom-in">
            <img src="../images/brands/dell.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center" data-aos="zoom-in">
            <img src="../images/brands/lenovo.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center" data-aos="zoom-in">
            <img src="../images/brands/apple.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center" data-aos="zoom-in">
            <img src="../images/brands/hp.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center" data-aos="zoom-in">
            <img src="../images/brands/samsung.png" class="img-fluid" alt="">
          </div>

        </div>

      </div>
    </section>
    <!-- End Brands Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="section-bg text-center">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>We Are at Your Service..</h2>
          <p>Shopping at TechZone is like Nothing Else..We would like to share the set of our services:</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch bg-light text-center">
            <div class="icon-box iconbox-blue">
              <div class="icon">
                <svg fill="#0275d8" class="primary" height="100px" width="100px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                  <g id="SVGRepo_iconCarrier">
                    <g transform="translate(1 1)">
                      <g>
                        <g>
                          <path d="M186.733,391.533c-9.387,0-17.067,7.68-17.067,17.067s7.68,17.067,17.067,17.067s17.067-7.68,17.067-17.067 S196.12,391.533,186.733,391.533z"></path>
                          <path d="M408.6,391.533c-9.387,0-17.067,7.68-17.067,17.067s7.68,17.067,17.067,17.067s17.067-7.68,17.067-17.067 S417.987,391.533,408.6,391.533z"></path>
                          <path d="M383,331.8h-17.067c-5.12,0-8.533,3.413-8.533,8.533s3.413,8.533,8.533,8.533H383c5.12,0,8.533-3.413,8.533-8.533 S388.12,331.8,383,331.8z"></path>
                          <path d="M255,246.467H135.533c-5.12,0-8.533,3.413-8.533,8.533s3.413,8.533,8.533,8.533H255c5.12,0,8.533-3.413,8.533-8.533 S260.12,246.467,255,246.467z"></path>
                          <path d="M139.8,102.253c-4.267-2.56-9.387-1.707-11.947,2.56L82.627,173.08l-26.453-26.453c-3.413-3.413-8.533-3.413-11.947,0 s-3.413,8.533,0,11.947l34.133,34.133c1.707,1.707,3.413,2.56,5.973,2.56c3.413,0,5.973-1.707,6.827-4.267l51.2-76.8 C144.92,109.933,144.067,104.813,139.8,102.253z"></path>
                          <path d="M499.907,313.88l-33.28-13.653l-21.333-85.333c-2.56-11.947-12.8-19.627-24.747-19.627h-80.213v-25.6 c0-9.387-7.68-17.067-17.067-17.067H186.348c0.25-2.81,0.385-5.655,0.385-8.533c0-52.053-41.813-93.867-93.867-93.867 C40.813,50.2-1,92.013-1,144.067c0,49.175,37.319,89.204,85.333,93.481v60.119v102.4c0,9.387,7.68,17.067,17.067,17.067h34.863 c4.095,24.134,25.217,42.667,50.47,42.667s46.375-18.533,50.47-42.667H358.13c4.095,24.134,25.217,42.667,50.47,42.667 c25.253,0,46.375-18.533,50.47-42.667h34.863c9.387,0,17.067-7.68,17.067-17.067v-69.973 C511,322.413,506.733,316.44,499.907,313.88z M323.267,203.8v8.533c0,42.667-34.133,76.8-76.8,76.8H101.4v-51.2 c7.334-0.815,14.48-2.445,21.316-4.802c13.123-4.362,24.935-11.528,34.735-20.798h114.616c5.12,0,8.533-3.413,8.533-8.533 s-3.413-8.533-8.533-8.533H171.794c5.064-7.748,8.999-16.334,11.526-25.6h139.947V203.8z M16.067,144.067 c0-42.667,34.133-76.8,76.8-76.8c42.667,0,76.8,34.133,76.8,76.8c0,4.703-0.438,9.294-1.233,13.756 c-0.199,0.504-0.361,1.038-0.474,1.604c-1.825,9.581-5.432,18.419-10.419,26.243c-0.283,0.442-0.555,0.891-0.847,1.326 c-0.153,0.229-0.317,0.45-0.472,0.678c-0.538,0.783-1.082,1.562-1.648,2.323c-0.112,0.151-0.229,0.299-0.343,0.449 c-0.619,0.821-1.251,1.631-1.902,2.425c-0.105,0.129-0.213,0.256-0.32,0.384c-0.666,0.802-1.348,1.591-2.046,2.364 c-0.11,0.122-0.221,0.244-0.333,0.366c-0.022,0.024-0.045,0.046-0.066,0.07c-1.769,0.79-3.112,2.145-3.887,3.926 c-0.278,0.262-0.548,0.533-0.83,0.791c-0.114,0.104-0.225,0.212-0.339,0.315c-0.821,0.743-1.66,1.467-2.513,2.174 c-0.07,0.057-0.136,0.118-0.206,0.175c-0.909,0.748-1.837,1.475-2.781,2.181c-0.333,0.248-0.676,0.482-1.013,0.725 c-0.57,0.412-1.141,0.825-1.723,1.222c-0.57,0.387-1.151,0.759-1.732,1.131c-0.355,0.228-0.708,0.459-1.067,0.682 c-0.668,0.413-1.345,0.812-2.026,1.204c-0.272,0.157-0.544,0.314-0.818,0.468c-0.747,0.418-1.501,0.825-2.263,1.219 c-0.198,0.103-0.397,0.203-0.597,0.304c-0.833,0.421-1.673,0.832-2.523,1.224c-0.087,0.04-0.175,0.078-0.262,0.118 c-4.708,2.147-9.666,3.826-14.806,4.999c-0.274,0.062-0.547,0.129-0.823,0.188c-0.77,0.167-1.547,0.316-2.325,0.46 c-0.43,0.079-0.861,0.157-1.293,0.229c-0.689,0.115-1.38,0.221-2.074,0.318c-0.557,0.077-1.117,0.146-1.678,0.211 c-0.606,0.071-1.212,0.142-1.822,0.199c-0.72,0.067-1.445,0.116-2.17,0.163c-0.477,0.031-0.952,0.071-1.432,0.094 c-1.225,0.057-2.456,0.092-3.696,0.092C50.2,220.867,16.067,186.733,16.067,144.067z M186.733,442.733 c-18.773,0-34.133-15.36-34.133-34.133c0-18.773,15.36-34.133,34.133-34.133c18.773,0,34.133,15.36,34.133,34.133 C220.867,427.373,205.507,442.733,186.733,442.733z M408.6,442.733c-18.773,0-34.133-15.36-34.133-34.133 c0-18.773,15.36-34.133,34.133-34.133c18.773,0,34.133,15.36,34.133,34.133C442.733,427.373,427.373,442.733,408.6,442.733z M493.933,400.067H459.07c-2.881-16.98-14.192-31.177-29.444-38.106c-0.338-0.155-0.674-0.314-1.017-0.462 c-0.214-0.092-0.432-0.175-0.648-0.264c-0.553-0.229-1.109-0.453-1.672-0.662c-0.152-0.056-0.306-0.108-0.459-0.163 c-0.625-0.226-1.256-0.442-1.893-0.644c-0.138-0.044-0.276-0.085-0.415-0.127c-0.648-0.199-1.302-0.387-1.962-0.56 c-0.146-0.038-0.292-0.076-0.439-0.113c-0.648-0.164-1.301-0.316-1.96-0.455c-0.166-0.035-0.331-0.071-0.497-0.104 c-0.636-0.128-1.277-0.242-1.922-0.346c-0.191-0.031-0.381-0.064-0.573-0.093c-0.621-0.093-1.248-0.17-1.877-0.24 c-0.213-0.024-0.425-0.052-0.639-0.074c-0.629-0.062-1.263-0.107-1.899-0.146c-0.21-0.013-0.417-0.033-0.628-0.043 c-0.837-0.041-1.68-0.065-2.529-0.065c-0.849,0-1.692,0.024-2.529,0.065c-0.21,0.01-0.418,0.03-0.628,0.043 c-0.636,0.039-1.27,0.084-1.899,0.146c-0.214,0.021-0.426,0.05-0.639,0.074c-0.629,0.07-1.256,0.148-1.877,0.24 c-0.192,0.029-0.382,0.062-0.574,0.093c-0.645,0.104-1.285,0.218-1.921,0.345c-0.167,0.034-0.332,0.069-0.498,0.104 c-0.658,0.139-1.311,0.291-1.959,0.455c-0.146,0.037-0.293,0.074-0.439,0.113c-0.66,0.174-1.314,0.361-1.962,0.561 c-0.138,0.042-0.276,0.083-0.414,0.127c-0.638,0.202-1.268,0.418-1.894,0.644c-0.152,0.055-0.305,0.107-0.457,0.163 c-0.564,0.21-1.121,0.434-1.675,0.664c-0.215,0.089-0.432,0.172-0.645,0.263c-0.343,0.148-0.68,0.308-1.019,0.463 c-15.25,6.93-26.561,21.126-29.441,38.105H237.203c-2.881-16.979-14.19-31.174-29.439-38.104 c-0.34-0.156-0.677-0.316-1.021-0.464c-0.213-0.091-0.43-0.174-0.645-0.263c-0.554-0.229-1.111-0.453-1.675-0.664 c-0.151-0.056-0.305-0.108-0.457-0.163c-0.626-0.226-1.257-0.442-1.894-0.644c-0.137-0.043-0.276-0.084-0.414-0.127 c-0.648-0.199-1.302-0.387-1.962-0.561c-0.146-0.038-0.292-0.076-0.439-0.113c-0.648-0.164-1.301-0.316-1.96-0.455 c-0.166-0.035-0.331-0.071-0.497-0.104c-0.636-0.128-1.277-0.242-1.922-0.346c-0.191-0.031-0.381-0.064-0.573-0.093 c-0.621-0.093-1.248-0.17-1.877-0.24c-0.213-0.024-0.425-0.052-0.639-0.074c-0.629-0.062-1.263-0.107-1.899-0.146 c-0.21-0.013-0.417-0.033-0.628-0.043c-0.837-0.041-1.68-0.065-2.529-0.065c-0.849,0-1.692,0.024-2.529,0.065 c-0.21,0.01-0.418,0.03-0.628,0.043c-0.636,0.039-1.27,0.084-1.899,0.146c-0.214,0.021-0.426,0.05-0.639,0.074 c-0.629,0.07-1.256,0.148-1.877,0.24c-0.192,0.029-0.382,0.062-0.573,0.093c-0.645,0.104-1.286,0.218-1.922,0.346 c-0.166,0.033-0.332,0.069-0.497,0.104c-0.659,0.139-1.312,0.291-1.96,0.455c-0.146,0.037-0.293,0.074-0.439,0.113 c-0.66,0.174-1.313,0.361-1.962,0.56c-0.138,0.042-0.277,0.083-0.415,0.127c-0.637,0.202-1.267,0.418-1.893,0.644 c-0.153,0.055-0.307,0.107-0.459,0.163c-0.563,0.21-1.119,0.433-1.672,0.662c-0.216,0.089-0.434,0.172-0.648,0.264 c-0.342,0.148-0.678,0.307-1.017,0.462c-15.252,6.929-26.563,21.126-29.444,38.106H101.4V306.2h145.067 c52.053,0,93.867-41.813,93.867-93.867h80.213c4.267,0,7.68,3.413,8.533,6.827l19.44,78.507h-62.96 c-5.973,0-11.093-5.12-11.093-11.093v-40.107c0-5.12-3.413-8.533-8.533-8.533s-8.533,3.413-8.533,8.533v40.107 c0,15.36,12.8,28.16,28.16,28.16h70.827l37.547,14.507V400.067z"></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <h4 class="text-primary">Fast Delivery</h4>
              <p>Your time is important for us,that's why we make sure your order will always arrive on time.</p>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 d-flex align-items-stretch bg-light">
            <div class="icon-box iconbox-blue">
              <div class="icon text-center">
                <svg viewBox="0 0 24 24" height="100px" width="100px" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                  <g id="SVGRepo_iconCarrier">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.73169L19.5 5.39836V12.75C19.5 15.6371 17.5419 18.9972 12.2605 20.9533L12 21.0498L11.7395 20.9533C6.45811 18.9972 4.5 15.6371 4.5 12.75V5.39836L12 3.73169ZM6 6.60161V12.75C6 14.8245 7.3659 17.6481 12 19.4479C16.6341 17.6481 18 14.8245 18 12.75V6.60161L12 5.26828L6 6.60161Z" fill="#3664ec"></path>
                  </g>
                </svg>
              </div>
              <h4><a href="">Secure Platform</a></h4>
              <p>Built with latest web technologies ,our platform provides a secure experience</p>
            </div>
          </div>
          <div class="col-lg-4 mx-auto col-md-6 d-flex align-items-stretch bg-light text-center">
            <div class="icon-box iconbox-blue">
              <div class="icon">
                <svg viewBox="0 0 24 24" class="text-center" height="100px" width="100px" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#1c31d4">
                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.8160000000000001"></g>
                  <g id="SVGRepo_iconCarrier">
                    <path d="M11.1459 12.5225C11.5259 11.8408 11.7159 11.5 12 11.5C12.2841 11.5 12.4741 11.8408 12.8541 12.5225L12.9524 12.6989C13.0603 12.8926 13.1143 12.9894 13.1985 13.0533C13.2827 13.1172 13.3875 13.141 13.5972 13.1884L13.7881 13.2316C14.526 13.3986 14.895 13.482 14.9828 13.7643C15.0706 14.0466 14.819 14.3407 14.316 14.929L14.1858 15.0812C14.0429 15.2483 13.9714 15.3319 13.9392 15.4353C13.9071 15.5387 13.9179 15.6502 13.9395 15.8733L13.9592 16.0763C14.0352 16.8612 14.0733 17.2536 13.8435 17.4281C13.6136 17.6025 13.2682 17.4435 12.5773 17.1254L12.3986 17.0431C12.2022 16.9527 12.1041 16.9075 12 16.9075C11.8959 16.9075 11.7978 16.9527 11.6014 17.0431L11.4227 17.1254C10.7318 17.4435 10.3864 17.6025 10.1565 17.4281C9.92674 17.2536 9.96476 16.8612 10.0408 16.0763L10.0605 15.8733C10.0821 15.6502 10.0929 15.5387 10.0608 15.4353C10.0286 15.3319 9.95713 15.2483 9.81418 15.0812L9.68403 14.929C9.18097 14.3407 8.92945 14.0466 9.01723 13.7643C9.10501 13.482 9.47396 13.3986 10.2119 13.2316L10.4028 13.1884C10.6125 13.141 10.7173 13.1172 10.8015 13.0533C10.8857 12.9894 10.9397 12.8926 11.0476 12.6989L11.1459 12.5225Z" stroke="#4e73ef" stroke-width="1.5"></path>
                    <path d="M21.8382 11.1263C22.0182 9.2137 22.1082 8.25739 21.781 7.86207C21.604 7.64823 21.3633 7.5172 21.106 7.4946C20.6303 7.45282 20.0329 8.1329 18.8381 9.49307C18.2202 10.1965 17.9113 10.5482 17.5666 10.6027C17.3757 10.6328 17.1811 10.6018 17.0047 10.5131C16.6865 10.3529 16.4743 9.91812 16.0499 9.04851L13.8131 4.46485C13.0112 2.82162 12.6102 2 12 2C11.3898 2 10.9888 2.82162 10.1869 4.46486L7.95007 9.04852C7.5257 9.91812 7.31351 10.3529 6.99526 10.5131C6.81892 10.6018 6.62434 10.6328 6.43337 10.6027C6.08872 10.5482 5.77977 10.1965 5.16187 9.49307C3.96708 8.1329 3.36968 7.45282 2.89399 7.4946C2.63666 7.5172 2.39598 7.64823 2.21899 7.86207C1.8918 8.25739 1.9818 9.2137 2.16181 11.1263L2.391 13.5616C2.76865 17.5742 2.95748 19.5805 4.14009 20.7902C5.32271 22 7.09517 22 10.6401 22H13.3599C16.9048 22 18.6773 22 19.8599 20.7902C20.7738 19.8553 21.0942 18.4447 21.367 16" stroke="#4e73ef" stroke-width="1.5" stroke-linecap="round"></path>
                  </g>
                </svg>
              </div class="text-center">
              <h4 class="text-primary">Premium Experience</a></h4>
              <p>Our Products meet hight quality standards. You will always find the thing you need </p>
            </div>
          </div>

        </div>
    </section><!-- End Sevices Section -->
    <!-- ======= News Section ======= -->
    <section id="faq" class="mx-auto">
      <div class="container text-center" data-aos="fade-up">
        <div class="section-title">
          <h2>Whats New ?</h2>
          <?php
          $q = "SELECT * FROM news";
          $res = mysqli_query($con, $q);
          $n = mysqli_num_rows($res);
          if ($n == 0) {
            echo "<h6 class='text-primary text-center display-6'>Nothing New. Stay tuned !</h6>";
          } else {
            echo '
            <div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">';
            for ($i = 0; $i < $n; $i++) {
              $row = mysqli_fetch_assoc($res);
              if ($i == 0) {
                echo ' <div class="carousel-item active">';
              } else {
                echo ' <div class="carousel-item">';
              }
              echo '  <img src="../uploads/news/' . $row['img'] . '" class="d-block w-100" style="object-fit: cover; height: 40em; width:40em;" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="text-dark fw-bolder text-primary">' . $row['title'] . '</h5>
        <p class="text-muted fs-50">' . $row['text'] . '</p>
      </div>
    </div>';
            }
            echo '</div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
            ';
          }
          ?>
    </section>
    <!-- End News Section -->
    <!-- ======= Contact Section ======= -->

    <!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer class="footer_section bg-primary mt-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-6 footer-col text-center">
          <div class="footer_detail mt-5 text-light">
            <h4 class="fw-bolder">
              About
            </h4>
            <p>
              we are doing our best to make your day ! If you like to support us , you can do so by following us on social media.
              Techzone
            </p>
          </div>
        </div>
        <div class="col-md-6 col-lg-6 footer-col text-center">
          <div class="footer_contact text-light">
            <h4 class="text-light fw-bolder mt-5">
              Reach at..
            </h4>
            <div class="contact_link_box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  Beirut
                </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Call: 71494437-71183394-76548841
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  techzone@gmail.com
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-info text-light">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">TechZone</a>
        </p>
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../css/index/purecounter/purecounter_vanilla.js"></script>
  <script src="../css/index/aos/aos.js"></script>
  <script src="../css/index/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../css/index/glightbox/js/glightbox.min.js"></script>
  <script src="../css/index/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../css/index/swiper/swiper-bundle.min.js"></script>
  <script src="../css/index/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../js/index-js.js"></script>

</body>

</html>