<?php
require_once '../helpers/connection.php';
require_once '../services/user.service.php';

session_start();
if(isset($_SESSION['admin'])){
  header("Location:admin-home.php");
}
if (isset($_SESSION)) {
  if (isset($_SESSION['user']))
    header('Location: account.php');
  else if (isset($_SESSION['admin']))
    header('Location: admin-home.php');
}
$errorLogin=null;

 if (isset($_POST['email']) && isset($_POST['password'])){

  $q  = "SELECT * FROM user WHERE email='".$_POST['email']."' AND isDeleted = 0";
  $res = mysqli_query($con,$q);
  $n = mysqli_num_rows($res);
  if($n == 0){
    $errorLogin = "Wrong Combination";
  }
  else{
    $q1 = "SELECT password from user WHERE email='".$_POST['email']."'";
    $hashedPasswordRes = mysqli_query($con,$q1);
    $hashedPassword = mysqli_fetch_assoc($hashedPasswordRes);
    if(password_verify($_POST['password'], $hashedPassword['password'])){
    $errorLogin= validateLogin(); 
  }
  else{
    $errorLogin = "Wrong Combination";
  }
 }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>Tech Zone: Login Page</title>

  <!--Bootstrap 5.2 style link-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="../css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />

</head>

<body class="sub_page">
  <!--Bootstrap 5.2 script section-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <div class="hero_area">

    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="home.php">
            <span>
             Tech Zone
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link fw-bolder" href="home.php">Home </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-bolder" href="shop.php"> Shop </a>
              </li>
              <li class="nav-item active">
                <a class="nav-link fw-bolder" href="contact.php">Contact Us <span class="sr-only">(current)</span> </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- contact section -->

  <section class="contact_section layout_padding">
    <div class="container mt-2 px-5">
      <div class="form_container">
        <div class="text-center">
          <h1 class="fw-bolder text-center text-primary">
            Login
          </h1>
        </div>
        <form method="post">
          <div>
            <input name="email" type="email" placeholder="Email" />
          </div>
          <div>
            <input name="password" type="password" placeholder="Password" />
          </div>
          <?php
          if(isset($_POST))
          echo $errorLogin;
          ?>
          <div class="text-center">
            <button type="submit" class="btn btn-large text-center btn-primary bg-primary border border-primary font-weight-bold">
              &nbsp;Sign in &nbsp;
            </button>
          </div>
          <br>
          <div class="d-flex justify-content-center">
            <a href="register.php" class="text-secondary link text-decoration-underline">Create Account</a>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- end contact section -->

  <!-- footer section -->
  <footer class="footer_section bg-primary mb-0">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-6 footer-col text-center">
          <div class="footer_detail">
            <h4>
              About
            </h4>
            <p>
              Necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with
            </p>
            <div class="footer_social justify-content-center">
              <a href="">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-twitter" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-instagram" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-6 footer-col text-center">
          <div class="footer_contact">
            <h4>
              Reach at..
            </h4>
            <div class="contact_link_box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  Location
                </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Call +01 1234567890
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  demo@gmail.com
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-info">
        <p>
          &copy;<span id="displayYear"></span> All Rights Reserved By<a href="https://html.design/">&nbsp;Laptops website</a>
        </p>
      </div>
  </footer>
  <!-- footer section -->

  <!-- jQery -->
  <script src="../js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script src="../js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- custom js -->
  <script src="../js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
  <!-- End Google Map -->

</body>

</html>