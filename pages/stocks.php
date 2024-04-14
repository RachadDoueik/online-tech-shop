<?php
require_once '../helpers/connection.php';
require_once '../services/category.service.php';

session_start();

$msgSuccess = '';

if (!isset($_SESSION) || !isset($_SESSION['admin']))
  header('Location: adminlogin.php');

if (array_key_exists('logout', $_POST)) {
  session_destroy();
  header("Refresh:0");
}
if (isset($_GET['categoryId']))
  $category = getCategoryById($_GET['categoryId']);

if (isset($_POST['category']))
  $msgSuccess = saveCategory();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Stocks</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!--style CSS Files -->
  <link href="../css/admin-style/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/admin-style/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../css/admin-style/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../css/admin-style/quill/quill.snow.css" rel="stylesheet">
  <link href="../css/admin-style/quill/quill.bubble.css" rel="stylesheet">
  <link href="../css/admin-style/remixicon/remixicon.css" rel="stylesheet">
  <link href="../css/admin-style/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../css/admin-style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="../pages/admin-home.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">TechZone</span>
      </a>
      <?php
      if (isset($_SESSION['name']))
        if (isset($_SESSION['admin']))
          echo 'Welcome ' . $_SESSION['name'] . ' ';
      ?>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="search" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
    </nav><!-- End Icons Navigation -->
    <?php
    if (isset($_SESSION['admin']))
      echo 'Admin page '
    ?>
    <?php
    if (isset($_SESSION['name']))
      echo '
            <form method="post">
            <button class="btn btn-primary mx-3" type="submit" name="logout" value="logout">Logout</button>
            </form>
            '
    ?>

  </header><!-- End Header -->


  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="admin-home">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="../pages/add-product.php">
          <i class="bi bi-plus-square"></i>
          <span>Add Products</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="../pages/filters.php">
          <i class="bi bi-ui-radios-grid"></i>
          <span>Manage Filters</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="../pages/user-details.php">
          <i class="bi bi-person-fill-gear"></i>
          <span>Manage Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="../pages/news.php">
          <i class="bi bi-newspaper"></i>
          <span>Manage News</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed text-primary" href="../pages/stocks.php">
          <i class="bi bi-ui-checks-grid"></i>
          <span>View Stock</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="../pages/orders.php">
          <i class="bi bi-card-checklist"></i>
          <span>View Orders</span>
        </a>
      </li>
      <!-- End Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->
  <main id="main" class="main">
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <form id="add-product" method="post" enctype="multipart/form-data">
            <div class="form-group">

              <div class="pagetitle">
                <h1>Products</h1>
                <nav>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">Products Section</li>
                  </ol>
                </nav>
              </div><!-- End Page Title -->
              <!--Display Products-->
              <?php
              if (isset($_POST['search']) && $_POST['search'] != "") {
                $q =   $q = "SELECT * FROM product WHERE (categoryId IN (SELECT categoryId FROM category NATURAL JOIN product WHERE categoryName LIKE '%" . $_POST['search'] . "%') OR productName LIKE '%" . $_POST['search'] . "%' OR  cond LIKE '%" . $_POST['search'] . "%' OR color LIKE '%" . $_POST['search'] . "%' OR brand  LIKE '%" . $_POST['search'] . "%' OR price LIKE '%" . $_POST['search'] . "%')";
                $res = mysqli_query($con, $q);
                $n = mysqli_num_rows($res);
                if ($n == 0) {
                  echo "<p class='text-dark '>No results for '" . $_POST['search'] . "'</p>";
                } else {
                  echo '   <table class="table table-striped ms-auto me-auto container-fluid" style="vertical-align: middle;">
                    <tr>
                    <th class="text-primary text-center ">Number</th>
                        <th class="text-primary text-center ">ID</th>
                        <th class="text-primary text-center ">Category</th>
                        <th class="text-primary text-center">Name</th>
                        <th class="text-primary text-center">Condition</th>
                        <th class="text-primary text-center">Brand</th>
                        <th class="text-primary text-center">Color</th>
                        <th class="text-primary text-center ">Price</th>
                        <th class="text-primary  text-center">Quantity</th>
                        <th class="text-primary  text-center">Added/Updated On</th>
                        <th class="text-primary" text-center">Actions</th>
                        <th class="text-primary" text-center">Logs</th>
                    </tr>';
                    for ($i = 0; $i < $n; $i++) {
                      $c = $i;
                      $row = mysqli_fetch_assoc($res);
                      $getlogs = "SELECT * FROM product NATURAL JOIN adminlog NATURAL JOIN admin WHERE productId='".$row['productId']."'";
                      $logs = mysqli_query($con,$getlogs);
                      $l = mysqli_num_rows($logs);
                      $q2 = "SELECT categoryName FROM category WHERE categoryId='" . $row['categoryId'] . "'";
                      $res2 = mysqli_query($con, $q2);
                      $row2 = mysqli_fetch_assoc($res2);
                      $categoryName = $row2['categoryName'];
                      echo "<tr><td class='p-1 text-center'>" . ++$c . "</td><td class='p-1 text-center'>" . $row['productId'] . "</td><td class='p-1 text-center'>" . $categoryName . "</td><td class='p-1 text-center'>" . $row['productName'] . "</td><td class='p-1 text-center'>" . $row['cond'] . "</td><td class='p-1 text-center'>" . $row['brand'] . "</td><td class='p-1 text-center'>" . $row['color'] . "</td><td class='p-1 text-center'>" . $row['price'] . "$</td><td class='p-1 text-center'>" . $row['quantityAvailable'] . "</td><td class='p-1 text-center'>" . $row['dateAdded'] . "</td><td class='p-1 '><a href='product-info.php?x=" . $row['productId'] . "&y=" . $categoryName . "' class='btn btn-primary mx-2'>Edit</a></td><td><div class='dropdown'>
                      <button class='btn btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        i
                      </button>";
                       echo" <ul class='dropdown-menu container-fluid display-flex w-100'>";
                       if($l == 0){
                        echo "<li class='text-center'>No logs </li>";
                       }
                       else{
                       for($p =0;$i<$l;$i++){
                        $s = mysqli_fetch_assoc($logs);
                        echo "<li class='container-fluid border border-dark'>Updated By ".$s['username']." on ".$s['updateDate']."</li>";
                       }
                      }
                  echo"    </ul>
                    </div></td></tr>";
                    }
                    echo "</table>";
                  }
              } else {
                $q = "SELECT * FROM product";
                $res = mysqli_query($con, $q);
                $n = mysqli_num_rows($res);
                if ($n == 0) {
                  echo "<p class='text-center text-danger'>No Products Yet !</p>";
                } else {
                  echo '   <table class="table table-striped ms-auto me-auto container-fluid" style="vertical-align: middle;">
                  <tr>
                  <th class="text-primary text-center ">Number</th>
                      <th class="text-primary text-center ">ID</th>
                      <th class="text-primary text-center ">Category</th>
                      <th class="text-primary text-center">Name</th>
                      <th class="text-primary text-center">Condition</th>
                      <th class="text-primary text-center">Brand</th>
                      <th class="text-primary text-center">Color</th>
                      <th class="text-primary text-center ">Price</th>
                      <th class="text-primary  text-center">Quantity</th>
                      <th class="text-primary  text-center">Added/Updated On</th>
                      <th class="text-primary" text-center">Edit</th>
                      <th class="text-primary" text-center">Logs</th>
                  </tr>';
                  for ($i = 0; $i < $n; $i++) {
                    $c = $i;
                    $row = mysqli_fetch_assoc($res);
                    $getlogs = "SELECT * FROM product NATURAL JOIN adminlog NATURAL JOIN admin WHERE productId='".$row['productId']."'";
                    $logs = mysqli_query($con,$getlogs);
                    $l = mysqli_num_rows($logs);
                    $q2 = "SELECT categoryName FROM category WHERE categoryId='" . $row['categoryId'] . "'";
                    $res2 = mysqli_query($con, $q2);
                    $row2 = mysqli_fetch_assoc($res2);
                    $categoryName = $row2['categoryName'];
                    echo "<tr><td class='p-1 text-center'>" . ++$c . "</td><td class='p-1 text-center'>" . $row['productId'] . "</td><td class='p-1 text-center'>" . $categoryName . "</td><td class='p-1 text-center'>" . $row['productName'] . "</td><td class='p-1 text-center'>" . $row['cond'] . "</td><td class='p-1 text-center'>" . $row['brand'] . "</td><td class='p-1 text-center'>" . $row['color'] . "</td><td class='p-1 text-center'>" . $row['price'] . "$</td><td class='p-1 text-center'>" . $row['quantityAvailable'] . "</td><td class='p-1 text-center'>" . $row['dateAdded'] . "</td><td class='p-1 '><a href='product-info.php?x=" . $row['productId'] . "&y=" . $categoryName . "' class='btn btn-primary mx-2'>Edit</a></td><td><div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                      i
                    </button>";
                     echo" <ul class='dropdown-menu container-fluid display-flex w-100'>";
                     if($l == 0){
                      echo "<li class='text-center'>No logs </li>";
                     }
                     else{
                     for($p =0;$i<$l;$i++){
                      $s = mysqli_fetch_assoc($logs);
                      echo "<li class='container-fluid border border-dark'>Updated By ".$s['username']." on ".$s['updateDate']."</li>";
                     }
                    }
                echo"    </ul>
                  </div></td></tr>";
                  }
                  echo "</table>";
                }
              }

              ?>
              <!--if (isset($_POST['search']) && $_POST['search'] !== "") {
                            $q = "SELECT * FROM user WHERE ( firstName LIKE '%" . $_POST['search'] . "%' OR firstName LIKE '%".$_POST['search']."%' OR lastName LIKE '%".$_POST['search']."%' OR email LIKE '%".$_POST['search']."%' OR phoneNumber LIKE '%".$_POST['search']."%')";
                            $res = mysqli_query($con, $q);
                            $n = mysqli_num_rows($res);
                            if ($n > 0) {
                                echo "<p class='text-primary text-center m-2'>Found " . $n . " results for '" . $_POST['search'] . "'.</p>";
                                echo' <table class="table table-striped ms-auto me-auto container-fluid" style="vertical-align: middle;">
                                <tr>
                                    <th class="text-primary text-center ">Number</th>
                                    <th class="text-primary text-center">Profile</th>
                                    <th class="text-primary text-center ">First Name</th>
                                    <th class="text-primary  text-center">Last Name</th>
                                    <th class="text-primary  text-center">Email</th>
                                    <th class="text-primary  text-center">Phone</th>
                                    <th class="text-primary  text-center">Birthday</th>
                                </tr>';
                                for ($i = 0; $i < $n; $i++) {
                                    $row = mysqli_fetch_assoc($res);
                                    echo '
                                <tr class="text-muted text-center">
                                    <td >' . ++$i . '</td>';
                                    if ($row['profilePicture'] != "") {
                                        echo '<td><img src="' . $row['profilePicture'] . '" width="100px" height="100px" class="m-4" /></td>';
                                    } else {
                                        echo '<td class="text-muted">No Image</td>';
                                    }
                                    echo '   <td>' . $row['firstName'] . '</td>
                                    <td>' . $row['lastName'] . '</td>
                                    <td>' . $row['email'] . '</td>
                                    <td>' . $row['phoneNumber'] . '</td>
                                    <td>' . $row['birthday'] . '</td>
                                </tr>
                                ';
                                }
                                echo "</table>";
                            } else {
                                echo "<p>no results found for '".$_POST['search']."'.</p>";
                            }
                        } else {
                            echo ' <table class="table table-striped ms-auto me-auto container-fluid" style="vertical-align: middle;">
                            <tr>
                                <th class="text-primary text-center ">Number</th>
                                <th class="text-primary text-center">Profile</th>
                                <th class="text-primary text-center ">First Name</th>
                                <th class="text-primary  text-center">Last Name</th>
                                <th class="text-primary  text-center">Email</th>
                                <th class="text-primary  text-center">Phone</th>
                                <th class="text-primary  text-center">Birthday</th>
                            </tr>';
                            foreach ($users as $key => $obj) {
                                echo '
                            <tr class="text-muted text-center">
                                <td >' . ++$key . '</td>';
                                if ($obj->profilePicture != "") {
                                    echo '<td><img src="' . $obj->profilePicture . '" width="100px" height="100px" class="m-4" /></td>';
                                } else {
                                    echo '<td class="text-muted">No Image</td>';
                                }
                                echo '   <td>' . $obj->firstName . '</td>
                                <td>' . $obj->lastName . '</td>
                                <td>' . $obj->email . '</td>
                                <td>' .  $obj->phoneNumber . '</td>
                                <td>' . $obj->birthday . '</td>
                            </tr>
                            ';
                            }
                            echo "</table>";
                        }-->

  </main><!-- End #main -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!--JS Files -->
  <script src="../css/admin-style/apexcharts/apexcharts.min.js"></script>
  <script src="../css/admin-style/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../css/admin-style/chart.js/chart.umd.js"></script>
  <script src="../css/admin-style/echarts/echarts.min.js"></script>
  <script src="../css/admin-style/quill/quill.min.js"></script>
  <script src="../css/admin-style/simple-datatables/simple-datatables.js"></script>
  <script src="../css/admin-style/tinymce/tinymce.min.js"></script>
  <script src="../css/admin-style/php-email-form/validate.js"></script>
  <!-- Template Main JS File -->
  <script src="../js/adminJS.js"></script>
</body>

</html>