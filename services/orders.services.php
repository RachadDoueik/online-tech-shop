<?php
require_once "../helpers/connection.php";
          $q = "SELECT * FROM cartproduct WHERE cartId='" . $_GET['x'] . "'";
          //get all products in chosen order's cart
          $res = mysqli_query($con, $q);
          $n  = mysqli_num_rows($res);
          //loop throught qtty of each product
          for ($i = 0; $i < $n; $i++) {
            $row = mysqli_fetch_assoc($res);
            $q1 = "SELECT quantityAvailable FROM product WHERE productId='" . $row['productId'] . "'";
            $res1 = mysqli_query($con, $q1);
            $restored =  $row['quantity'];
            $row1 = mysqli_fetch_assoc($res1);
            $available = $row1['quantityAvailable'];
            $update = "UPDATE product SET quantityAvailable = '" . ($available + $restored) . "' WHERE productId='" . $row['productId'] . "'";
            $upRes = mysqli_query($con, $update);
            $delete = "DELETE FROM delivery WHERE cartId='" . $_GET['x'] . "'";
            $final = mysqli_query($con, $delete);
            echo "Order is Canceled Successfully! Refresh page to take Effect.";
            echo "<br>";
          }
          header("Location:../pages/user-orders.php");
        ?>