<?php
require_once '../services/cart.service.php';
require_once '../models/cartUpdater.php';
session_start();

$cartProducts = getCartProducts();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if (isset($productToUpdate)) {
        $allProducts=[];
        $selectedProduct;
        foreach($cartProducts as $i=>$cartProduct){
            $product=new cartUpdater($productIds[$i],$quantity[$i]);
            $allProducts[]=$product;
        }
        foreach($allProducts as $item){
            if($item->productId==$productToUpdate){
                $selectedProduct=$item;
            }
        }
        print_r($selectedProduct);
        // updateProductFromCart($selectedProduct->productId, $selectedProduct->quantityToUpdate);
        // header("Refresh:0");
        // exit();
    } else if (isset($productToRemove)) {
        $productId = $productToRemove;
        $updatedQuantity;
        print_r($productToRemove);
        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->productId == $productId) $updatedQuantity = $cartProduct->quantityAvailable;
        }

        removeProductFromCart($productId, $updatedQuantity);
        header("Refresh:0");
        exit();
    }
    if (array_key_exists('logout', $_POST)) {
        session_destroy();
        header("Refresh:0");
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

    <title>Tech Zone: Cart</title>

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

    <style>
        /* Hide the number input spinner controls */
        #quantityGroup input[type="number"]::-webkit-inner-spin-button,
        #quantityGroup input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

</head>

<body class="sub_page">
    <!--Bootstrap 5.2 script section-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <div class="hero_area">

        <!-- header section strats -->
        <header class="header_section mb-4">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="home.php">
                        <span>
                            Tech Zone
                        </span>
                    </a>
                    <?php
                    if (isset($_SESSION['name']))
                        if (isset($_SESSION['admin']))
                            echo 'Welcome admin ' . $_SESSION['name'];
                        else echo 'Welcome ' . $_SESSION['name'];
                    ?>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link fw-bolder text-muted" href="home.php">Home </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bolder text-muted" href="shop.php"> Shop </a>
                            <li class="nav-item active">
                                <a class="nav-link fw-bolder text-muted" href="contact.php">Contact Us <span class="sr-only">(current)</span> </a>
                            </li>
                        </ul>
                        <div class="user_option-box">
                            <?php
                             if(isset($_SESSION['user'])){
                                $q = "SELECT profilePicture FROM user WHERE userId='".$_SESSION['user']."'";
                                $res = mysqli_query($con,$q);
                                if($res){
                                $user = mysqli_fetch_assoc($res);
                                $picture = $user['profilePicture'];
                                if($picture == NULL){
                                  echo'  <a href="login.php">
                                  <i class="fa fa-user-o" aria-hidden="true"></i>
                                </a>';
                                }
                                else{
                                  echo ' <a href="login.php">
                                  <img src='.$picture.' alt="user" style="height: 1.5rem; width: 1.5rem; border-radius: 5rem; margin: 0.5rem 0 0.5rem 0;"/>
                                </a>';
                                }
                              }
                            }
                              else{
                                echo' <a href="login.php">
                                 <i class="fa fa-user-o" aria-hidden="true"></i>
                               </a>';
                               }
                             ?>
                            <div class="dropstart">
                                <button type="button" class="bg-transparent border-0 ml-3" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                    <i class="fa fa-cart-plus text-primary fw-bolder" aria-hidden="true"></i>
                                </button>
                            </div>
                            <?php
            if(isset($_SESSION)&&isset($_SESSION['user'])){
              $q = "SELECT COUNT(wpId) AS count FROM wishlistproduct WHERE wishlistId ='".$_SESSION['user']."'";
              $res = mysqli_query($con,$q);
              if($res){
                $row = mysqli_fetch_assoc($res);
                if($row['count'] != 0){
                  echo '
                  <a href="wishlist.php">
                  <i class="fa fa-heart-o" aria-hidden="true"><span class="position-absolute start-101 translate-middle badge rounded-pill bg-primary">'.$row['count'].'</span></i></a>';
                }
                else{
                echo '
                <a href ="wishlist.php"><i class="fa fa-heart-o "></i></a>';
                }
              }
            }
                else{
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
    </div>

    <!-- shop section -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-5 text-primary display-6">My Cart</h1>
            </div>
        </div>
   <?php
        if (!empty($cartProducts) && gettype($cartProducts) == 'array') {
            $total = 0;
            echo '
    <div class="row mb-4 container">
      <div class="col-12">
      <form method="post">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Product</th>
              <th scope="col"></th>
              <th scope="col" style="text-align: center;">Quantity</th>
              <th scope="col">Total</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>';
  
            foreach ($cartProducts as $cartProduct) {
                $total += $cartProduct->price * $cartProduct->quantityAvailable;
                echo '
            <tr>
                <td style="vertical-align: middle;">
                    <a href="viewproduct?productId=' . $cartProduct->productId . '">
                        <img src="' . $cartProduct->thumbnail . '" class="img-fluid" alt="Item Image" style="max-width: 100px; max-height: 100px;">
                    </a>
                </td>
                <td style="vertical-align: middle;">
                    <a href="viewproduct?productId=' . $cartProduct->productId . '">
                        <h3 class="card-title font-weight-bolder " style="font-size: 1.2rem;">' . $cartProduct->productName . '</h3>
                            <p class="card-text text-muted" style="font-size: 1rem;">' . $cartProduct->description . '</p>
                            <p class="card-text font-weight-bold" style="font-size: 1.2rem;">Price: $' . $cartProduct->price . '</p>
                    </a>
                </td>
                <td style="vertical-align: middle;">
                    <div class="input-group" id="quantityGroup">
                       
                            <input type="hidden" name="productIds[]"value="' . $cartProduct->productId . '" >
                            <input type="number" id="quantity" name="quantity[]" class="form-control text-center" min="1" value="' . $cartProduct->quantityAvailable . '" readonly>
                       
                    </div>
                </td>
                <td style="vertical-align: middle;">$' . ($cartProduct->price * $cartProduct->quantityAvailable) . '</td>
                <td style="vertical-align: middle;">
                    <button class="btn btn-outline-danger" style="font-size: 1.1rem;" name="productToRemove" value="' . $cartProduct->productId . ' ">Remove</button>
                </td>
            </tr>';
            }
  
            echo '
          </tbody>
        </table>    
        </form>
      </div>
      <div class="col-6">           
        </div>    
        <div class="col-6">
        <h4 class="text-muted font-weight-bolder">Subtotal: ' . $total . '$</h4>
        <a href="checkout.php" class="btn btn-primary w-100">Checkout</a>
        </div>
    </div>';
        } else {
            echo '<div class="row">
            <div class="col-12 text-center mb-5">
                <h3>Your cart is empty.</h3>
            </div>
            <a class="btn btn-outline-primary mb-5" href="shop.php" style="font-size: 1.1rem;">Shop Now</a>
          </div>';
        }
        ?>
    </div>

    <!-- end shop section -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
    </script>
    <!-- custom js -->
    <script src="../js/custom.js"></script>

    <script>
        const quantityChange = (action) => {
            let quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);

            switch (action) {
                case 'add':
                    quantityInput.value = currentValue + 1;
                    break;
                case 'reduce':
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    } else console.log('You can\'t add 0 items');
                    break;
            }
        }
    </script>
</body>

</html>