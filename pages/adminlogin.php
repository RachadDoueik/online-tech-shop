<?php
require_once '../helpers/connection.php';
require_once '../services/admin.service.php';
session_start();
if (isset($_SESSION)) {
    if (isset($_SESSION['user']))
        header('Location: home.php');
    else if (isset($_SESSION['admin']))
        header('Location: admin-home.php');
}



$error_message = '';

if (isset($_POST) && isset($_POST['username']) && isset($_POST['password'])) {
    $error_message = validateLogin();
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

    <title>Admin Login</title>

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
          <?php
          if (isset($_SESSION['name']))
            echo 'Welcome ' . $_SESSION['name'];
          ?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link fw-bolder text-primary" href="home.php">Home </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted" href="shop.php"> Shop </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-bolder text-muted" href="contact.php">Contact Us</a>
              </li>
            </ul>
            <div class="user_option-box">
            </div>
          </div>
        </nav>
      </div>
    </header>
        <!-- end header section -->
    </div>

    <!-- contact section -->
    <section class="contact_section layout_padding p-5 mt-5 justify-content-center">
        <div class="container">
            <div class="form_container">
                <div class="text-center">
                    <h2 class="display-5 text-primary fw-bolder">
                        Admin Login
                    </h2>
                </div>
                <form method="post">
                    <div>
                        <br>
                        <input type="text" placeholder="Username" name="username" />
                        <br>
                    </div>
                    <div>
                        <br>
                        <input type="password" placeholder="Password" name="password" />
                        <br>
                    </div>
                    <?php
                    echo $error_message;
                    ?>
                    <div class="text-center">
                        <button type="submit" class="btn border border-primary bg-primary btn-large btn-primary ms-auto me-auto">
                            &nbsp;Sign in &nbsp;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- end contact section -->

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