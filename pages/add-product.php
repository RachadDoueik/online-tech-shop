<?php
require_once '../services/category.service.php';
require_once '../services/category.service.php';
require_once '../services/product.service.php';

session_start();
if (!isset($_SESSION) || !isset($_SESSION['admin']))
  header('Location: adminlogin.php');

if (array_key_exists('logout', $_POST)) {
  session_destroy();
  header("Refresh:0");
}

if (isset($_POST) && isset($_POST['quantity']) && !empty($_FILES['image1']['name']) && !empty($_FILES['image2']['name'])) {
  $msgSuccess = addProduct();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tech Zone: Add Products Page</title>
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
        <a class="nav-link collapsed text-primary" href="../pages/add-product.php">
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
                <h1>Products</h1>
                <nav>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Products Section </li>
                    <li class="text-danger fw-bolder"> &nbsp;(All Fields Are Required)</li>
                  </ol>
                </nav>
              </div>
              <label for="productName">Product name</label>
              <input type="text" required class="form-control mb-3" id="productName" name="productName" />
            </div>
            <div class="form-group">
              <label for="quantity">Quantity</label>
              <input type="number" required class="form-control mb-3" id="quantity" name="quantity" min="1" max="100" />
            </div>
            <div class="form-group" id="innerSerial">
            </div>
            <div class="form-group">
              <label for="Category">Category</label>
              <select class="form-control mb-3" id="category" name="category">
                <?php
                $categories = getCategories();
                if (count($categories) > 0) {
                  foreach ($categories as $category) {
                    echo '<option value="' . $category->categoryId . '">' . $category->categoryName . '</option>';
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="description">Descritpion</label>
              <textarea type="text" placeholder="Add Description" class="form-control mb-3" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
              <label for="price">Price</label>
              <input type="text" required class="form-control mb-3" id="price" name="price" />
            </div>
            <div class="form-group mb-3">
              <label for="brand">Brand</label>
              <select class="form-control" name="brand" id="brand">
              <?php
                $brands = file("../helpers/brands.txt");
                foreach($brands as $brand){
                  echo "<option value='".$brand."'>".$brand."</option>";
                }
                 ?>
              </select>
            </div>
            <div class="form-group mb-3">
              <label for="color">Color</label>
              <select name="color" id="color" class="form-control">
                <?php
                $colors = file("../helpers/colors.txt");
                foreach($colors as $color){
                  $val = explode("-",$color);
                  echo "<option value='".$color."' style='background-color:".$val[1]."'>".$val[0]."</option>";
                }
                 ?>
              </select>
            </div>
            <div class="form-group mb-3">
              <label for="brand">Condition</label>
              <select name="condition" id="condition" class="form-control">
                <option value="New">New</option>
                <option value="Used">Used</option>
                <option value="Refurbished">Refurbished</option>
                <option value="Open Box">Open Box</option>
              </select>
            </div>
            <div class="form-group">
              <label for="thumbnail" class="form-label">Thumbnail</label>
              <input type="file" required class="form-control mb-3" id="thumbnail" name="thumbnail" />
            </div>
            <div class="form-group">
              <label for="images" class="form-label">Images</label>
              <input type="file" required class="form-control mb-3" id="images" name="image1" />
              <input type="file" required class="form-control mb-3" id="images" name="image2" />
            </div>
            <?php
            if (isset($_POST['productName'])) {
              echo $msgSuccess . '<br/><br/>';
            }
            ?>
            <button type="submit" class="btn btn-primary">Add</button>
            <button type="reset" class="btn btn-primary">Reset</button>
          </form>
        </div>
      </div>
    </section>

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