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

if (isset($_POST['saveCategory']) && $_POST['category'] != "") {
  $msgSuccess = saveCategory();
} else if (isset($_POST['addb']) && $_POST['addBrand'] != "") {
  $file = fopen("../helpers/brands.txt", "a");
  fwrite($file, "\n" . $_POST['addBrand']);
  fclose($file);
} else if (isset($_POST['addc']) && $_POST['addColor'] != "" && isset($_POST['hexcode'])) {
  $file = fopen("../helpers/colors.txt", "a");
  $newColor = "\n" . $_POST['addColor'] . "-" . $_POST['hexcode'];
  fwrite($file, $newColor);
  fclose($file);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Filters Page</title>
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
        <a class="nav-link collapsed text-primary" href="../pages/filters.php">
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
        <a class="nav-link collapsed" href="../pages/stocks.php">
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
                <h1>Filters</h1>
                <nav>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Filters Section</li>
                  </ol>
                </nav>
              </div><!-- End Page Title -->

              <div id="form-container" class="col">
                <form class="mb-3" id="add-product" method="post">
                  <h1 class="display-6 text-dark text-center">Categories</h1>
                  <div class="form-group">
                    <label for="category"><?php echo isset($category) ? $category->categoryName . ' Selected' : 'Insert new Category'; ?></label><br />
                    <input type="text" class="form-control mb-3" id="productName" name="category" value='<?php
                                                                                                          if (isset($category)) {
                                                                                                            echo $category->categoryName;
                                                                                                          } else  "" ?>' />
                    <input name="categoryId" type="hidden" value='<?php
                                                                  if (isset($category)) {
                                                                    echo $category->categoryId;
                                                                  } else  "" ?>' />
                  </div>
                  <?php
                  echo $msgSuccess;
                  ?>
                  <button type="submit" name="saveCategory" class="btn btn-primary">Save</button>
                  <a href="filters.php" class="btn btn-secondary">Refresh</a>
                </form>
                <?php echo $categoryMessage ?>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $categories = getCategories();
                    if (count($categories) > 0) {
                      foreach ($categories as $i => $category) {
                        echo "<tr>
                    <th scope='row'>" . $i + 1, "</th>" .
                          "<td>" . $category->categoryName . "</td>" .
                          "<td><a class='btn btn-sm btn-primary mx-2'href='./filters.php?categoryId=" . $category->categoryId . "'>Edit</a></td>
                   </tr>";
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="container-fluid m-3 p-2">
                <h1 class="display-6 text-dark text-center">Brands</h1>
                <div>
                  <p class="text-muted ">Current Brands</p>
                  <select class="form-control" id="brand">
                    <?php
                    $brands = file("../helpers/brands.txt");
                    foreach ($brands as $brand) {
                      echo "<option value='" . $brand . "'>" . $brand . "</option>";
                    }
                    ?>
                  </select>
                  <div class="input-group">
                    <input class="form-control" type="text" name="addBrand" placeholder="Add a new brand" size="30">
                    <input type="submit" name="addb" class="btn btn-primary" value="Add">
                  </div>
                </div>
              </div>
              <div class="container-fluid m-3 p-2">
                <h1 class="display-6 text-dark text-center">Colors</h1>
                <div>
                  <p class="text-muted ">Current Colors</p>
                  <select class="form-control" id="color">
                    <?php
                    $colors = file("../helpers/colors.txt");
                    foreach ($colors as $color) {
                      $val = explode("-", $color);
                      echo "<option value='" . $color . "' style='background-color:" . $val[1] . "'>" . $val[0] . "</option>";
                    }
                    ?>
                  </select>
                  <div class="input-group">
                    <input class="form-control w-50" type="text" name="addColor" placeholder="new color name (Also Choose Hex Code)" size="40">
                    <input type="color" name="hexcode" class="form-control" style="margin: 0.5em; height: 1.5em; border-radius: 3em; width: 3em;">
                    <input type="submit" name="addc" class="btn btn-primary" value="Add">
                  </div>
                </div>
              </div>
            </div>
            <div>
            </div>
        </div>
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