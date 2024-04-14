<?php
require_once '../helpers/cartItems.php';
require_once '../services/cart.service.php';
require_once '../helpers/connection.php';

session_start();

$cartProducts = getCartProducts();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($removeProduct)) {
    removeProductFromCart($cartProductId, $cartQuantity);
    header("Refresh:0");
    exit();

    if (array_key_exists('logout', $_POST)) {
      session_destroy();
      header("Refresh:0");
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

  <title>Tech Zone: Contact Us Page</title>
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

<body>
  <!--Bootstrap 5.2 script section-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <!-- header section strats -->
  <header class="header_section bg-light shadow-sm">
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
            <li class="nav-item">
              <a class="nav-link fw-bolder text-muted bg-light" href="home.php">Home </a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-bolder text-muted bg-light" href="shop.php"> Shop </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link fw-bolder text-primary bg-light active" href="contact.php">Contact Us</a>
            </li>
          </ul>
          <div class="user_option-box">
              <?php
              if (isset($_SESSION['admin']))
                echo 'Admin page '
              ?>
              <?php
              if (isset($_SESSION['user'])) {
                $q = "SELECT profilePicture FROM user WHERE userId='" . $_SESSION['user'] . "'";
                $res = mysqli_query($con, $q);
                if ($res) {
                  $user = mysqli_fetch_assoc($res);
                  $picture = $user['profilePicture'];
                  if ($picture == NULL) {
                    echo '  <a href="login.php">
                      <i class="fa fa-user-o" aria-hidden="true"></i>
                    </a>';
                  } else {
                    echo ' <a href="login.php">
                      <img src=' . $picture . ' alt="user" style="height: 1.5rem; width: 1.5rem; border-radius: 5rem; margin: 0.5rem 0 0.5rem 0;"/>
                    </a>';
                  }
                }
              } else {
                echo ' <a href="login.php">
                     <i class="fa fa-user-o" aria-hidden="true"></i>
                   </a>';
              }
              ?>    
              <?php
              if (isset($_SESSION) && isset($_SESSION['user'])) {
                $q = "SELECT COUNT(wpId) AS count FROM wishlistproduct WHERE wishlistId ='" . $_SESSION['user'] . "'";
                $res = mysqli_query($con, $q);
                if ($res) {
                  $row = mysqli_fetch_assoc($res);
                  if ($row['count'] != 0) {
                    echo '
                  <a href="wishlist.php">
                  <i class="fa fa-heart-o" aria-hidden="true"><span class="position-absolute start-101 translate-middle badge rounded-pill bg-primary">' . $row['count'] . '</span></i></a>';
                  } else {
                    echo '
                <a href ="wishlist.php"><i class="fa fa-heart-o "></i></a>';
                  }
                }
              } else {
                echo '<div class="btn-group dropstart bg-none">
                  <button class="btn border border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <i class="fa fa-heart-o"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li class="p-2 text-center text-primary">No Account</li>
                  </ul>
                </div>';
              }
              ?>
            </div>
        </div>
      </nav>
    </div>
  </header>
  <!-- end header section -->


  <!-- contact section -->

  <section class="contact_section p-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <div>
              <h2 class="text-primary text-center display-6">
                Contact Us
              </h2>
            </div>
            <form action="" method="post" name="form">
              <div>
                <input type="text" id="input" name="name" required placeholder="*Full Name " />
              </div>
              <div>
                <input type="email" name="email" required placeholder="*Email" />
              </div>
              <div>
                <input type="text" name="phone" placeholder="Phone number" />
              </div>
              <div>
                <input type="text" name="message" required class="message-box"  placeholder="*Message" />
              </div>
              <?php
                if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']) && $_POST['name'] != "" && $_POST['email'] != "" && $_POST['message'] != "" ) {
                  $name = $_POST['name'];
                  $email = $_POST['email'];
                  $message = $_POST['message'];
                  $phone = "";
                  if (isset($_POST['phone'])) {
                    $phone .= $_POST['phone'];
                  } else {
                    $phone .= "NA";
                  }
                  $q = "INSERT INTO contacts(contactName,contactEmail,contactPhone,message) VALUES('" . $name . "','" . $email . "','" . $phone . "','" . $message . "')";
                  $res = mysqli_query($con, $q);
                  if($q){
                    echo "Message Sent !";
                  }
                  else{
  
                  }
                }
              
              ?>
              <div class="text-center">
                <button onclick="submitForm()" type="submit" class="btn btn-sm border border-primary bg-primary">SEND</button>
              </div>
              </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="img-box ms-5">
            <img src="../images/mail.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end contact section -->
  <br>
  <!-- footer section -->
  <footer class="footer_section bg-primary">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-6 footer-col text-center">
          <div class="footer_detail">
            <h4>
              About
            </h4>
            <p>
             We are doing our best to make your day ! If you like to support us , you can do so by following us on social media.
              Techzone
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
      <div class="footer-info">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">TechZone</a>
        </p>
      </div>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- custom js -->
  <script src="../js/custom.js"></script>
  <script>
    function submitForm() {
   var frm = document.getElementsByName('form')[0];
   frm.submit();
   frm.reset(); 
   return false;
}
  </script>
</body>

</html>