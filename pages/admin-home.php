<?php
require_once '../helpers/connection.php';
require_once '../services/category.service.php';
require_once '../services/product.service.php';

session_start();
if (!isset($_SESSION) || !isset($_SESSION['admin'])) {
  header('Location: adminlogin.php');
}

if (array_key_exists('logout', $_POST)) {
  session_destroy();
  header("Refresh:0");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tech Zone: Admin Home Page</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../css/admin-style/icon.png" rel="icon">
  <link href="../css/admin-style/le-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
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
        <span class="d-none d-lg-block text-dark fw-bolder">TechZone</span>
      </a>
      <?php
      if (isset($_SESSION['name']))
        if (isset($_SESSION['admin']))
          echo 'Welcome ' . $_SESSION['name'] . ' ';
      ?>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
    </nav>
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
        <a class="nav-link" href="admin-home.php">
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
      <!-- End Blank Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <?php
            $q = "SELECT COUNT(deliveryId) AS dnb FROM delivery WHERE paymentStatus = 'received'";
            $res = mysqli_query($con, $q);
            $row = mysqli_fetch_assoc($res);
            echo ' <!-- Sales Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                  <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                      </div>
                      <div class="ps-3">
                        <h6>' . $row['dnb'] . ' Orders</h6>
                        <span class="text-success small pt-1 fw-bold">in total</span> <span
                          class="text-muted small pt-2 ps-1"></span>

                      </div>
                    </div>
                  </div>

                </div>
              </div>';

            ?><!-- End Sales Card -->

            <!-- Revenue Card -->
            <?php
            $g = "SELECT SUM(total) AS totalIncome FROM delivery";
            $res = mysqli_query($con, $g);
            $row = mysqli_fetch_assoc($res);
            echo '  <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                  <div class="card-body">
                    <h5 class="card-title">Total Income (US Dollars)</h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-currency-dollar"></i>
                      </div>
                      <div class="ps-3">
                        <h6>' . $row['totalIncome'] . '</h6>
                        <span class="text-success small pt-1 fw-bold">us dollars</span> <span
                          class="text-muted small pt-2 ps-1"></span>

                      </div>
                    </div>
                  </div>

                </div>
              </div>';
            ?>
            <!-- Customers Card -->
            <?php
            $g = "SELECT count(userId) AS usercount FROM user";
            $res = mysqli_query($con, $g);
            $row = mysqli_fetch_assoc($res);
            echo '  <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                  <div class="card-body">
                    <h5 class="card-title">Customers</h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                      </div>
                      <div class="ps-3">
                        <h6>' . $row['usercount'] . ' Customers</h6>
                        <span class="text-success small pt-1 fw-bold">in total</span> <span
                          class="text-muted small pt-2 ps-1"></span>
                      </div>
                    </div>
                  </div>

                </div>
              </div>';
            ?>
            <!-- Recent Sales -->
            <!-- End Recent Sales -->

            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>
            </div><!-- End Top Selling -->
            <div>
              <div class="pagetitle">
                <h1>Contacts</h1>
                <nav>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Users Messages</li>
                  </ol>
                </nav>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                  <?php
                  $q = "SELECT * FROM contacts";
                  $res = mysqli_query($con,$q);
                  $n = mysqli_num_rows($res);
                  for($i=0;$i<$n;$i++){
                    $row= mysqli_fetch_assoc($res);
                    $p = "";
                    if($row['contactPhone'] == ""){
                      $p = "NA";
                    }
                    else{
                      $p = $row['contactPhone'];
                    }
                    echo'
                    <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-heading'.$i.'">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse'.$i.'" aria-expanded="false" aria-controls="flush-collapseOne">
                        Message By '.$row['contactName'].'
                      </button>
                    </h2>
                    <div id="flush-collapse'.$i.'" class="accordion-collapse collapse" aria-labelledby="flush-heading'.$i.'" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body">'.$row['message'].'   <code>'.$row['contactEmail'].' </code> '.$row['sentOn'].'        Phone: '. $p .'</div>
                    </div>
                  </div>';
                  }
                   ?>
</div>
              </div>
            </div>
          </div>
        </div><!-- End Left side columns -->
      </div><!-- End Right side columns -->

    </section>

  </main><!-- End #main -->

  <!-- Vendor JS Files -->
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