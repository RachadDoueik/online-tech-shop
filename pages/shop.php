<?php
require_once '../services/cart.service.php';
require_once '../services/category.service.php';
require_once '../services/product.service.php';
require_once '../helpers/cartItems.php';

session_start();

$categories = getCategoriesWithProductsAvailable();
$cartProducts = getCartProducts();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($removeProduct)) {
    removeProductFromCart($cartProductId, $cartQuantity);
    header("Refresh:0");
    exit();
  }
  if (array_key_exists('logout', $_POST)) {
    session_destroy();
    header("Refresh:0");
  }
}
function isExpired(DateTime $startDate, DateInterval $validFor)
{
  $now = new DateTime();

  $expiryDate = clone $startDate;
  $expiryDate->add($validFor);

  return $now > $expiryDate;
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

  <title>Tech Zone: Shopping Page</title>

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
  <!-- additional style-->
  <style>
    .range_container {
      display: flex;
      flex-direction: column;
      width: 80%;
      margin: 2em;
    }

    .sliders_control {
      position: relative;
      min-height: 2em;
    }

    .form_control {
      position: relative;
      display: flex;
      justify-content: space-between;
      font-size: 1em;
      color: #635a5a;
    }

    input[type=range]::-webkit-slider-thumb {
      -webkit-appearance: none;
      pointer-events: all;
      width: 1em;
      height: 1em;
      background-color: #0D6EFD;
      border-radius: 50%;
      box-shadow: 0 0 0 1px #C6C6C6;
      cursor: pointer;
    }

    input[type=range]::-moz-range-thumb {
      -webkit-appearance: none;
      pointer-events: all;
      width: 24px;
      height: 24px;
      background-color: #fff;
      border-radius: 50%;
      box-shadow: 0 0 0 1px #C6C6C6;
      cursor: pointer;
    }

    input[type=range]::-webkit-slider-thumb:hover {
      background: #f7f7f7;
    }

    input[type=range]::-webkit-slider-thumb:active {
      box-shadow: inset 0 0 3px #387bbe, 0 0 9px #387bbe;
      -webkit-box-shadow: inset 0 0 3px #387bbe, 0 0 9px #387bbe;
    }

    input[type="number"] {
      color: #0D6EFD;
      width: 4em;
      height: 2em;
      font-size: 1em;
      border: none;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      opacity: 1;
    }

    input[type="range"] {
      -webkit-appearance: none;
      appearance: none;
      height: 2px;
      width: 100%;
      position: absolute;
      background-color: #C6C6C6;
      pointer-events: none;
    }

    #fromSlider {
      height: 0;
      z-index: 1;
      color: black;
    }
  </style>
</head>

<body onload="keepSelectedChoices()" class="sub_page">
  <!--Bootstrap 5.2 script section-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <!-- header section start -->
  <header class="header_section bg-light">
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
            <li class="nav-item  pt-lg-2">
              <a class="nav-link fw-bolder text-muted bg-light" href="home.php">Home </a>
            </li>
            <li class="nav-item active  pt-lg-2">
              <a class="nav-link fw-bolder text-primary bg-light active" href="shop.php"> Shop </a>
            </li>
            <li class="nav-item  pt-lg-2">
              <a class="nav-link fw-bolder text-muted bg-light" href="contact.php">Contact Us</a>
            </li>
            <li class="p-3 pt-lg-2 justify-content-center">
              <div>
                <form action="" method="get">
                  <input type="text" name="search" placeholder="Search" title="Enter search keyword" style="border-radius: 10px 0 0 10px;" class="border-0">
                  <button type="submit" title="Search" class="btn-primary border-0" style="border-radius: 0 10px 10px 0px;"><i class="fa fa-search"></i></button>
                </form>
              </div>
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


            <div class="dropstart">
              <a class="ml-3" data-bs-toggle="dropdown">
                <i class="fa fa-cart-plus text-muted" aria-hidden="true"></i>
              </a>
              <ul class="dropdown-menu">
                <?php renderCartItems($cartProducts) ?>
              </ul>
            </div>
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
  </ul>
  </div>
  <button class="btn btn-dark mt-3 border-0 p-2" style="z-index:100;position:fixed; border-radius: 0 2rem 2rem 0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Filters</button>
  <!-- end header section -->
  <!--Filters Section-->
  <div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasExampleLabel" style="overflow-y:scroll">
    <form class="search-form" method="POST" action="#" onsubmit="return handleError()">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filters</h5>
        <div class="">
          <button onclick="sessionStorage.clear()" type="reset" name="reset" value="" class="btn btn-light mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
              <path d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H463.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V448c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352H176c17.7 0 32-14.3 32-32s-14.3-32-32-32H48.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z" />
            </svg></button>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
      </div>
      <div class="offcanvas-body">
        <p class="m-2 fw-bolder py-2">Sort:</p>
        <select class="form-select" aria-label="Default select example" name="sort">
        <option value="none">None</option>
          <option value="alpha">Alphabetically (A-Z)</option>
          <option value="alphaR">Alphabetically (Reverse)</option>
          <option value="p">Price (Low-High)</option>
          <option value="pR">Price (High-Low)</option>
          <option value="re">Reviews</option>
        </select>
        <p class="m-2 fw-bolder py-2">Categories:</p>
        <?php
        echo "<table class='m-2'>";
        foreach ($categories as $i => $category) {
          if ($i % 2 == 0) {
            echo "</tr><tr>";
          }
          echo "<td class='text-start px-1'><label class='fs-8' for='" . $category->categoryId . "'><input type='checkbox' onclick='addToSaved(this)' id='" . $category->categoryId . "' name='category[]' value='" . $category->categoryId . "'/> " . $category->categoryName . "</label></td>";
        }
        echo "</table>";
        ?>
        <p class="m-2 fw-bolder py-2">Condition:</p>
        <div class="px-3 my-2">
          <label class="mx-1" for="new"></label><input type="checkbox" onclick="addToSaved(this)" id="new" name="condition[]" value="New"> New</label>
          <label class="mx-1" for="used"></label><input type="checkbox" onclick="addToSaved(this)" id="used" name="condition[]" value="Used"> Used</label>
          <br>
          <label class="mx-1" for="refurb"></label><input type="checkbox" onclick="addToSaved(this)" id="refurb" name="condition[]" value="Refurbished"> Refurbished</label>
          <label class="mx-1" for="refurb"></label><input type="checkbox" onclick="addToSaved(this)" id="ob" name="condition[]" value="OpenBox"> Open Box</label>
        </div>
        <p class="m-2 fw-bolder">Brands:</p>
        <div class="container my-2">
          <table>
            <?php
            $getBrands = "SELECT DISTINCT(brand) AS brands FROM product";
            $res = mysqli_query($con, $getBrands);
            $num = mysqli_num_rows($res);
            for ($i = 0; $i < $num; $i++) {
              $row = mysqli_fetch_assoc($res);
              if ($i % 2 == 0) {
                echo "</tr><tr>";
              }
              echo "<td class='text-start px-2'><label class='fs-8' for='" . $row["brands"] . "'><input id='" . $row['brands'] . "' type='checkbox' onclick=' addToSaved(this)' name='brand[]' value='" . $row["brands"] . "'/> " . $row["brands"] . "</label></td>";
            }
            echo "</table>";
            ?>
        </div>
        <?php
        $getMaxPrice = "SELECT MAX(price) AS maxP , MIN(price) AS minP FROM product";
        $res = mysqli_query($con, $getMaxPrice);
        $row = mysqli_fetch_assoc($res);
        echo '<p class="m-2 fw-bolder">Price: <input type=checkbox class="btn mx-3 text-muted" onclick="priceEnable(this)">Set</button></p>
            <div class="range_container">
              <div class="sliders_control">
                <input id="fromSlider" disabled="true" type="range" value="" min="' . $row['minP'] . '" max="' . $row['maxP'] . '" oninput="fromInput.value=fromSlider.value" />
                <input id="toSlider" disabled="true" type="range" value="" min="' . $row['minP'] . '" max="' . $row['maxP'] . '" oninput="toInput.value=toSlider.value" />
              </div>
            <div class="form_control">
            <div class="form_control_container">
              <div class="form_control_container__time">Min</div>
              <input class="form_control_container__time__input" disabled="true" type="number" name="minPrice" id="fromInput" min="' . $row['minP'] . '" max="' . ($row['maxP']) . '" oninput="fromSlider.value=fromInput.value" />
            </div>
            <div class="form_control_container">
            <div class="form_control_container__time">Max</div>
            <input class="form_control_container__time__input"disabled="true" type="number" name="maxPrice" id="toInput" min="' . ($row['minP']) . '" max="' . $row['maxP'] . '" oninput="toSlider.value=toInput.value" />
          </div>';
        ?>
      </div>
      <div class="text-danger text-start m-2 fs-sm" id="priceError"></div>
  </div>
  <p class="m-2 fw-bolder">Colors:</p>
  <div class="container">
    <?php
    $getColors = "SELECT DISTINCT(color) AS colors FROM product";
    $result = mysqli_query($con, $getColors);
    $num_colors = mysqli_num_rows($result);
    if ($num_colors == 0) {
      echo "<p>No Products Yet !!</p>";
    } else {
      echo "<table>";
      for ($i = 0; $i < $num_colors; $i++) {
        $color = mysqli_fetch_assoc($result);
        $colorInfo = explode("-", $color["colors"]);
        $colorName = $colorInfo[0];
        $colorCode = $colorInfo[1];
        if ($i % 2 == 0) {
          echo "</tr><tr>";
        }
        echo "<td class='text-start w-50'><input type='checkbox' onclick='addToSaved(this)' name=color[] id='" . $colorName . "' value='" . $color["colors"] . "' class='btn-check' autocomplete='off'>
          <label for='" . $colorName . "' class='btn' style='background-color:" . $colorCode . "'>" . $colorName . "</label></td>";
      }
      echo "</table>";
    }
    ?>
  </div>
  <div class="p-3 m-2 text-end">
    <input type="submit" onclick="" class="btn btn-primary" name="filters" value="Go">
  </div>
  </div>
  </form>
  </div>
  <!--Filters Section End-->
  <!--Shop Section-->

  <?php
  //initial query------------------
  $query = "SELECT * FROM product";
  //-------------------------------
  $choices = array();
  //checking filters availability
  if (isset($_POST['filters']) && (isset($_POST['category']) || isset($_POST['color']) || isset($_POST['brand']) || isset($_POST['condition']) || isset($_POST['minPrice']))) {
    echo ' <section class="shop_section mb-5">
       <div class="row px-3">';
    $counter = 0;
    //filter 1: condition----------
    if (isset($_POST['condition'])) {
      if ($counter == 0) {
        $query .= " WHERE ";
      } else {
        $query .= " AND ";
      }
      $query .= "(";
      foreach ($_POST['condition'] as $i => $cond) {
        $choices[] = $cond;
        if ($i != count($_POST['condition']) - 1) {
          $query .= "cond ='" . $cond . "' OR ";
        } else {
          $query .= "cond='" . $cond . "')";
        }
      }
      $counter++;
    } else {
      $query .= "";
    }
    //end filter 1-----------------
    // filter 2: category------------
    if (isset($_POST['category'])) {
      if ($counter == 0) {
        $query .= " WHERE ";
      } else {
        $query .= " AND ";
      }
      $query .= "(";
      foreach ($_POST['category'] as $i => $categoryId) {
        $q = "SELECT categoryName FROM category WHERE categoryId='" . $categoryId . "'";
        $allCatgs = mysqli_query($con, $q);
        $row = mysqli_fetch_assoc($allCatgs);
        $choices[] = $row['categoryName'];
        if ($i != count($_POST['category']) - 1) {
          $query .= "categoryId ='" . $categoryId . "' OR ";
        } else {
          $query .= "categoryId='" . $categoryId . "' )";
        }
      }
      $counter++;
    } else {
      $query .= "";
    }
    //end filter 2------------------------
    //filter 3: brand--------------------------
    if (isset($_POST['brand'])) {

      if ($counter == 0) {
        $query .= " WHERE ";
      } else {
        $query .= " AND ";
      }
      foreach ($_POST['brand'] as $i => $brandName) {
        $choices[] = $brandName;
        if ($i != count($_POST['brand']) - 1) {
          $query .= "brand ='" . $brandName . "' OR ";
        } else {
          $query .= "brand='" . $brandName . "' ";
        }
      }
      $counter++;
    } else {
      $query .= "";
    }
    //end filter 3 ---------------------------------------
    //filter 4: price-------------------------------------
    if (isset($_POST['minPrice']) && isset($_POST['maxPrice'])) {
      if ($counter == 0) {
        $query .= " WHERE ";
      } else {
        $query .= " AND ";
      }
      $query .= " price >= '" . $_POST['minPrice'] . "' AND  price <= '" . $_POST['maxPrice'] . "' ";
      $choices[] = "Price Range: $" . $_POST['minPrice'] . " - $" . $_POST['maxPrice'] . "";
      $counter++;
    } else {
      $query .= "";
    }
    //end filter 4------------------------------------------
    //filter 5: color---------------------------------------
    if (isset($_POST['color'])) {
      if ($counter == 0) {
        $query .= " WHERE ";
      } else {
        $query .= " AND ";
      }
      foreach ($_POST['color'] as $i => $color) {
        $name = explode("-", $color);
        $choices[] = $name[0];
        if ($i != count($_POST['color']) - 1) {
          $query .= "color ='" . $color . "' OR ";
        } else {
          $query .= "color ='" . $color . "' ";
        }
      }
      $counter++;
    } else {
      $query .= "";
    }
    //end filter 5-------------------------------------------
    $res = mysqli_query($con, $query);
    $n = mysqli_num_rows($res);
    echo "<div class='container-fluid mt-5' style='overflow-x: scroll;'>";
    echo "<ul class='d-inline-flex' style='list-style-type: none;'>";
    foreach ($choices as $choice) {
      echo "<li class='bg-primary mx-2 fs-5 shadow text-light border px-2 py-1 rounded-pill'>" . $choice . "</li>";
    }
    echo "</ul>";
    echo "</div>";
    //end filter checking-----------------------------------------------------------
    //output if filters are set------------------------------------------------------
    if ($n != 0) {
      for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($res);
        $startDate = new DateTime($row['dateAdded']);
        $validFor = new DateInterval('P3D');
        $isExpired = isExpired($startDate, $validFor);
        echo '
          <div class="col-12 col-md-6 col-lg-3 my-3">
          <a href="viewproduct.php?productId=' . $row['productId'] . '">
          <div class="card text-black shadow">
            <img src="' . $row['thumbnail'] . '"
              class="w-100" style="object-fit:cover;height: 15em;" />
            <div class="card-body">
              <div class="text-center">
                <h5 class="card-title">' . $row['productName'] . '</h5>
              </div>
              <div>
                <div class="d-flex justify-content-between">';
        if ($row['quantityAvailable'] > 0) {
          if (!$isExpired) {
            echo '<span class="text-light py-1  bg-primary px-3 border rounded-pill">New</span>';
          } else {
          echo '<span class="px-3 py-1">&nbsp;</span>';;
          }
          echo '<span>in Stock Units: ' . $row['quantityAvailable'] . '</span>';
        } else {
          echo '<span class="text-light py-1 bg-danger px-3 border rounded-pill">Out Of Stock</span>';
        }
        echo '</div>
              </div>
              <div class="d-flex justify-content-between total font-weight-bold mt-4">
                <span>Price</span><span>$' . $row['price'] . '</span>
              </div>
            </div>
          </div>
          </a>
        </div>';
      }
    } else {
      echo "<div class='m-5'>";
      echo "<h5 class='text-center display-5'>No Products match your Filters !</h5>";
      echo "<h6 class='text-muted text-center lead display-6'>make sure you entered correct informations, or try using The Search Bar</h6>";
      echo "</div>";
    }
    echo '</div>
    </div>
    </section>';
  } else if (isset($_GET['search']) && $_GET['search'] != "") {
    $query = "SELECT * FROM product WHERE productName LIKE '%" . $_GET['search'] . "%' OR description LIKE '%" . $_GET['search'] . "%' OR color LIKE '%" . $_GET['search'] . "%' OR cond LIKE '%" . $_GET['search'] . "%' OR brand LIKE '%" . $_GET['search'] . "%'";
    $res = mysqli_query($con, $query);
    $n = mysqli_num_rows($res);
    if ($n == 0) {
      echo  "<p class='text-info text-center p-5 m-5'>No results found for `" . $_GET['search'] . "`. Check the spelling or use a different word or phrase.<a href='shop.php' class='btn btn-primary ms-5 text-light'><i class='fa fa-arrow-up mx-1'></i>Back</a></p>";
      echo "<br>";
    } else {
      echo "<p class='text-info text-center m-3'>Found " . $n . " result(s) for `" . $_GET['search'] . "`";
      echo "<br>";
      echo ' <section class="shop_section container-fluid">
      <div class="row px-3">';
      for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($res);
        $startDate = new DateTime($row['dateAdded']);
        $validFor = new DateInterval('P3D');
        $isExpired = isExpired($startDate, $validFor);
        echo '
          <div class="col-12 col-md-6 col-lg-3 my-3">
          <a href="viewproduct.php?productId=' . $row['productId'] . '">
          <div class="card text-black shadow">
            <img src="' . $row['thumbnail'] . '"
              class="w-100" style="object-fit:cover;height: 15em;" />
            <div class="card-body">
              <div class="text-center">
                <h5 class="card-title">' . $row['productName'] . '</h5>
              <div>
                <div class="d-flex justify-content-between">';
        if ($row['quantityAvailable'] > 0) {
          if (!$isExpired) {
            echo '<span class="text-light py-1  bg-primary px-3 border rounded-pill">New</span>';
          } else {
            echo '<span class="px-3 py-1">&nbsp;</span>';
          }
          echo '<span>in Stock Units: ' . $row['quantityAvailable'] . '</span>';
        } else {
          echo '<span class="text-light py-1 bg-danger px-3 border rounded-pill">Out Of Stock</span>';
        }
        echo '</div>
              </div>
              <div class="d-flex justify-content-between total font-weight-bold mt-4">
                <span>Price</span><span>$' . $row['price'] . '</span>
              </div>
            </div>
          </div>
          </a>
        </div>';
      }
    }
    echo '   </div>
        </div>
        </section>';
  } else {
    if (isset($_POST['sort']) && $_POST['sort'] != "none") {
      $query = "";
      switch ($_POST['sort']) {
        case "alpha":
          $query = "SELECT * FROM product ORDER BY productName";
          break;
        case "alpha":
          $query = "SELECT * FROM product ORDER BY productName";
          break;
        case "alphaR":
          $query = "SELECT * FROM product ORDER BY productName DESC";
          break;
        case "p":
          $query = "SELECT * FROM product ORDER BY price";
          break;
        case "pR":
          $query = "SELECT * FROM product ORDER BY price DESC";
          break;
        case "re":
          $query = "SELECT productId, categoryId, productName, description, price, quantityAvailable, dateAdded, thumbnail, cond, color, brand , COUNT(reviewId) AS revCount FROM product NATURAL JOIN review GROUP BY productId ORDER BY revCount ";
      }
      $res = mysqli_query($con, $query);
      $n = mysqli_num_rows($res);
      echo ' <section class="shop_section container-fluid">
        <div class="row px-3 py-2">';
      for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($res);
        $startDate = new DateTime($row['dateAdded']);
        $validFor = new DateInterval('P3D');
        $isExpired = isExpired($startDate, $validFor);
        echo '
            <div class="col-12 col-md-6 col-lg-3 my-3">
            <a href="viewproduct.php?productId=' . $row['productId'] . '">
            <div class="card text-black shadow">
              <img src="' . $row['thumbnail'] . '"
                class="w-100" style="object-fit:cover;height: 15em;" />
              <div class="card-body">
                <div class="text-center">
                  <h5 class="card-title">' . $row['productName'] . '</h5>
                </div>
                <div>
                  <div class="d-flex justify-content-between">';
        if ($row['quantityAvailable'] > 0) {
          if (!$isExpired) {
            echo '<span class="text-light py-1  bg-primary px-3 border rounded-pill">New</span>';
          } else {
            echo '<span class="px-3 py-1">&nbsp;</span>';
          }
          echo '<span>in Stock Units: ' . $row['quantityAvailable'] . '</span>';
        } else {
          echo '<span class="text-light py-1 bg-danger px-3 border rounded-pill">Out Of Stock</span>';
        }
        echo '</div>
                </div>
                <div class="d-flex justify-content-between total font-weight-bold mt-4">
                  <span>Price</span><span>$' . $row['price'] . '</span>
                </div>
              </div>
            </div>
            </a>
          </div>';
      }
      echo '</div>
        </div>
        </section>';
    } else {
      echo '<section style="background-color: #eee;" class="container-fluid">';
      echo '<div class="container-fluid">';
      foreach ($categories as $category) {
        echo ' <div class="row">';
        echo "<h6 class='text-light display-6 py-2 container-fluid justify-center text-center bg-primary'>" . $category->categoryName . "</h6>";
        $prods = "SELECT * FROM product WHERE categoryId='" . $category->categoryId . "'";
        $catProds = mysqli_query($con, $prods);
        $n = mysqli_num_rows($catProds);
        for ($i = 0; $i < $n; $i++) {
          $row = mysqli_fetch_assoc($catProds);
          $startDate = new DateTime($row['dateAdded']);
          $validFor = new DateInterval('P3D');
          $isExpired = isExpired($startDate, $validFor);
          echo '
            <div class="col-12 col-md-6 col-lg-3 my-3">
            <a href="viewproduct.php?productId=' . $row['productId'] . '">
            <div class="card text-black shadow">
              <img src="' . $row['thumbnail'] . '"
                class="w-100" style="object-fit:cover;height: 15em;" />
              <div class="card-body">
                <div class="text-center">
                  <h5 class="card-title">' . $row['productName'] . '</h5>
                </div>
                <div>
                  <div class="d-flex justify-content-between">';
          if ($row['quantityAvailable'] > 0) {
            if (!$isExpired) {
              echo '<span class="text-light py-1  bg-primary px-3 border rounded-pill">New</span>';
            } else {
              echo '<span class="px-3 py-1">&nbsp;</span>';
            }
            echo '<span>in Stock Units: ' . $row['quantityAvailable'] . '</span>';
          } else {
            echo '<span class="text-light py-1 bg-danger px-3 border rounded-pill">Out Of Stock</span>';
          }
          echo '</div>
                </div>
                <div class="d-flex justify-content-between total font-weight-bold mt-4">
                  <span>Price</span><span>$' . $row['price'] . '</span>
                </div>
              </div>
            </div>
            </a>
          </div>';
        }
        echo ' </div>';
      }
      echo '
       </div>
      </section>';
    }
  }
  ?>
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

  <!-- Modal -->
  <div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ok, <?php echo $product ?> cart, what's next?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Continue Shopping</button>\
        </div>
      </div>
    </div>
  </div>
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
    function handleError() {
      let x = document.getElementById("fromInput").value;
      let y = document.getElementById("toInput").value;
      let e = document.getElementById("priceError");
      if (!(Number(x) <= Number(y))) {
        e.innerHTML = "Min Should Be Lower Than or Equal to Max !"
        return false;
      } else {
        e.innerHTML = "";
        return true;
      }
    }

    function priceEnable(csc) {
      let x = document.getElementById("fromInput");
      let y = document.getElementById("toInput");
      let s1 = document.getElementById("fromSlider");
      let s2 = document.getElementById("toSlider");
      if (csc.checked == true) {
        x.disabled = false;
        y.disabled = false;
        s1.disabled = false;
        s2.disabled = false;
      } else {
        x.disabled = true;
        y.disabled = true;
        s1.disabled = true;
        s2.disabled = true;
      }
    }

    function addToSaved(checks) {
      let saved = Object.keys(sessionStorage);
      if (checks.checked == true) {
        if (saved.indexOf(checks) == -1) {
          sessionStorage.setItem(checks.id, checks.id);
        }
      } else {
        sessionStorage.removeItem(checks.id)
      }
    }

    function resetSavedchoices() {
      sessionStorage.clear();
    }

    function keepSelectedChoices() {
      let saved = Object.keys(sessionStorage);
      if (saved.length != 0) {
        for (let id of saved) {
          let thisCheckbox = document.getElementById(id);
          thisCheckbox.checked = true;
        }
      }
    }
  </script>
</body>

</html>