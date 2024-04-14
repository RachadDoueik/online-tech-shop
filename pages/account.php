<?php
require_once '../services/user.service.php';
require_once '../helpers/cartItems.php';
require_once '../helpers/connection.php';


session_start();
$cartProducts = getCartProducts();
$successMsg = '';
if (isset($_SESSION['user']))
  $user = getUserById($_SESSION['user']);
else (header('Location: home.php'));

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['MS'])) {
  $successMsg = $_GET['MS'];
  switch ($successMsg) {
    case 1:
      $successMsg = 'Error Updating User';
      break;
    case 2:
      $successMsg = 'Error Uploading Profile Picture';
      break;
    case 3:
      $successMsg = 'Info Updated Successfully';
      break;
    case 5:
      $successMsg = 'Password Updated Successfully';
      break;
    default:
      $successMsg = null;
      break;
  }
}
if (isset($_POST['confirm'])) {
  $msg = "";
  $q  = "SELECT password FROM user NATURAL JOIN delivery WHERE userId='" . $_SESSION['user'] . "'";
  $res = mysqli_query($con, $q);
  $deliveryCount  = "SELECT * FROM delivery WHERE userId='" . $_SESSION['user'] . "' AND paymentStatus ='waiting approval'";
  $counts = mysqli_query($con, $deliveryCount);
  $d = mysqli_num_rows($counts);
  $row = mysqli_fetch_assoc($res);
  if (isset($_POST['deleteAccount']) && password_verify($_POST['deleteAccount'], $row['password']) && $d == 0) {
    $update = "UPDATE user SET isDeleted=1 WHERE userId='" . $_SESSION['user'] . "'";
    $res = mysqli_query($con, $update);
    session_destroy();
    header("Location:index.php");
  } else {
    $msg = "<p class='text-danger'>Wrong Password</p>";
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  extract($_POST);
  if (isset($submit)) {
    if (isset($_POST['currentPassword']) && isset($newPassword)) {
      $q = "SELECT password FROM user WHERE userId='" . $_SESSION['user'] . "'";
      $res = mysqli_query($con, $q);
      $row = mysqli_fetch_assoc($res);
      if (password_verify($currentPassword, $row['password'])) {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $q1 = "UPDATE user SET password='" .$hash. "' WHERE userId='" . $_SESSION['user'] . "'";
        $res1 = mysqli_query($con, $q1);
      }
    }
    $MSG = updateUser($_SESSION['user']);
    header('Location: account.php?MS=' . $MSG . '');
  }
  if (isset($removeProduct)) {
    removeProductFromCart($cartProductId, $cartQuantity);
    header("Refresh:0");
    exit();
  }
}

if (array_key_exists('logout', $_POST)) {
  session_destroy();
  header("Refresh:0");
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
  <!--Bootstrap 5.2 links-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <title>Tech Zone: Account Page</title>


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
  <!-- header section -->
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
              <a class="nav-link fw-bolder text-muted m-1" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-bolder text-muted m-1" href="shop.php"> Shop </a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-bolder text-muted m-1" href="contact.php">Contact Us</a>
            </li>
            <?php
            if (isset($_SESSION['name']))
              echo '
            <li class="nav-item"><form method="post">
            <button class="btn btn-primary m-1" type="submit" name="logout" value="logout">Logout</button>
            </form></li>
            <li class="nav-item">
            <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Delete Account
          </button>
            </form></li>
            ';
            ?>
            <li>
              <a href="../pages/user-orders.php" class="m-1 btn btn-secondary">Track Orders</a>
            </li>
          </ul>
          <div class="user_option-box">
            <a href="login.php">
              <i class="fa fa-user-o" aria-hidden="true"></i>
            </a>
            <div class="dropstart">
              <button type="button" class="bg-transparent border-0 ml-3" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
              </button>
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
  <!-- end header section -->

  </div>
<?php
echo "<p class='text-center mt-1 text-dark'>$successMsg</p>'";
  ?>
  <!-- Account section -->
  <section>
    <div class="conatiner m-3">
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value=<?php echo $user->userId ?> />
        <div class="row">
          <div class="col-lg-12 justify-content-center text-center">
            <label for="profilePicture">
              <img src=<?php echo $user->profilePicture ? $user->profilePicture : "../images/defaultProfile.jpg" ?> width="200rem" height="200rem " class="rounded-pill mx-auto mt-3" alt="Profile Picture" id="profilePicturePreview">
              <input type="file" id="profilePicture" name="profilePicture" style="display: none;" onchange="handleProfilePicture(event)" disabled>
              <p class="text-center lead text-muted">Change Picture</p>
            </label>
          </div>
        </div>
        <div clas="row">
          <table class="mx-auto display-sm-block">
            <tr>
              <td width=50% class="p-2">
                <label for="firstName" class="text-primary fs-4">First Name</label>
                <input type="text" class="form-control text-primary fs-5" id="firstName" name="firstName" value=<?php echo $user->firstName ?> disabled />
              </td>
              <td width=50% class="p-2">
                <label for="lastName" class="text-primary fs-4">Last Name</label>
                <input type="text" class="form-control text-primary fs-5" id="lastName" name="lastName" value=<?php echo $user->lastName ?> disabled />
              </td>
            </tr>
            <tr>
              <td width=50% class="p-2">
                <label for="email" class="text-primary fs-4">Email</label>
                <input type="text" readonly class="form-control text-primary fs-5" id="email" name="email" value=<?php echo $user->email ?> disabled />
              </td>
              <td width=50% class="p-2">
                <label for="phoneNumber" class="text-primary fs-4">Phone Number</label>
                <input type="text" class="form-control text-primary fs-5" id="phoneNumber" name="phoneNumber" value=<?php echo $user->phoneNumber ?> disabled />
              </td>
            </tr>
            <tr>
              <td colspan="2" width=100% class="text-center p-2">
                <label for="birthday" class="text-primary fs-4">Birthday</label>
                <input type="date" class="form-control text-primary fs-5" id="birthday" name="birthday" value=<?php echo $user->birthday ?> disabled />
              </td>
            </tr>
            <tr>
              <td width=50% class="p-2">
                <label for="currentPassword" class="text-primary fs-4">Current Password</label>
                <input type="text" class="form-control text-primary fs-5" id="currentPassword" name="currentPassword" disabled />
              </td>
              <td width=50% class="p-2">
                <label for="newPassword" class="text-primary fs-4">New Password</label>
                <input type="text" class="form-control text-primary fs-5" id="newPassword" name="newPassword" disabled />
              </td>
            <tr width=100% class="p-2">
              <td class="text-center" colspan="2">
                <button type="button" class="btn btn-primary  mx-2" id="edit" name="edit" onclick="editFields()">Edit</button> <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Save Changes" disabled />
              </td>
            </tr>
            </tr>
          </table>
        </div>
    </div>
  </section>

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
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Account</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete your TechZone account ? This Cannot Be Undone.
          (Deleting account with pending orders can not be done)
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#setPass">
            Proceed
          </button>
        </div>
      </div>
    </div>
  </div>
  <form action="" method="post">
    <div class="modal fade" id="setPass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="setPass" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Account</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Confirm password:
            <input type="text" class="form-control" name="deleteAccount">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="confirm" class="btn btn-danger">Delete Account</button>
          </div>
        </div>
      </div>
    </div>
  </form>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
  <script>
    function editFields() {
      var inputs = document.getElementsByTagName("input");
      for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = false;
      }
      document.getElementById("submit").disabled = false;
    }

    function handleProfilePicture(event) {
      var input = event.target;
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById("profilePicturePreview").src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
</body>

</html>