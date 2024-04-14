<?php
require_once '../helpers/dbWrapper.php';
require_once '../helpers/connection.php';
require_once '../models/user.php';
require_once 'cart.service.php';


function getUsers()
{
    $wrapper = new dbWrapper();

    $getUsersQuery = "SELECT * FROM user";

    $results = $wrapper->executeQuery($getUsersQuery);

    $users = [];

    if (!empty($results)) {
        foreach ($results as $result) {
            $user = new User();
            $user->userId = isset($result['userId']) ? $result['userId'] : null;
            $user->firstName = isset($result['firstName']) ? $result['firstName'] : null;
            $user->lastName = isset($result['lastName']) ? $result['lastName'] : null;
            $user->email = isset($result['email']) ? $result['email'] : null;
            $user->phoneNumber = isset($result['phoneNumber']) ? $result['phoneNumber'] : null;
            $user->birthday = isset($result['birthday']) ? $result['birthday'] : null;
            $user->profilePicture = isset($result['profilePicture']) ? $result['profilePicture'] : null;
            $user->isDeleted= isset($result['isDeleted']) ? $result['isDeleted'] : null;
            $users[] = $user;
        }
        return $users;
    }
}

function getUserById($id)
{
    $wrapper = new dbWrapper();
    $user = new User();

    if (isset($id)) {
        $query = 'SELECT * FROM user WHERE userId="' . $id . '"';
        $result = $wrapper->executeQuery($query);

        $user->userId = $result[0]['userId'];
        $user->firstName = $result[0]['firstName'];
        $user->lastName = $result[0]['lastName'];
        $user->email = $result[0]['email'];
        $user->birthday = $result[0]['birthday'];
        $user->profilePicture = $result[0]['profilePicture'];
        $user->phoneNumber = $result[0]['phoneNumber'];
        $user->password = $result[0]['password'];

        return $user;
    } else $user = null;
    return $user;
}


function validateLogin()
{
    $wrapper = new dbWrapper();
    extract($_POST);
        $query = 'SELECT userId, firstName, lastName FROM user WHERE email="' . $email . '"';
        $result = $wrapper->executeSingleRowQuery($query);
        $count = count($result);
    if ($count === 0) {
        return 'Authentication failed';
    } else if ($count > 1) {
        return 'Please contact your administrator';
    } else if ($count === 1) {
        $_SESSION['user'] = $result[0]['userId'];
        $_SESSION['name'] = $result[0]['firstName'] . ' ' . $result[0]['lastName'];
        header('Location: ../pages/home.php');
        exit();
    }
}



function signup()
{
    $wrapper = new dbWrapper();
    if (alreadyExists($_POST['email'])) {
        return 'Email Already Used ! Please Enter another one';
    }
    else {

        if (isset($_POST['firstName']) && $_POST['firstName'] != "" && isset($_POST['lastName']) && $_POST['lastName'] != "" && isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['phoneNumber']) && $_POST['phoneNumber'] != "" && isset($_POST['password']) && $_POST['password'] != "") {
          $_POST['password'] =  password_hash($_POST['password'],PASSWORD_BCRYPT);
            $query = 'INSERT INTO user(firstName,lastName,email,phoneNumber,password,birthday) 
                VALUES("' . $_POST['firstName'] . '","' . $_POST['lastName'] . '","' . $_POST['email'] . '","' . $_POST['phoneNumber'] . '","' . $_POST['password'] . '",
                "' . $_POST['birthday'] . '")';
            $id = $wrapper->executeQueryAndReturnId($query);
            createCart($id);
            createWishlist($id);
            header("Location:../pages/login.php");
        } else {
            header("Location: ../pages/register.php");
            return 'Error creating account';
        }
    }
}


function updateUser($id)
{
    $wrapper = new dbWrapper();

    extract($_POST);
    $destination;
    $isSuccessUploadingImg;
    $isSuccessUpdatingUser;
    $isSuccessUpdatingPass;
    if (isset($firstName) && isset($lastName) && isset($email) && isset($phoneNumber)) {
        if (!empty($_FILES['profilePicture']['name'])) {

            $destination = '../uploads/ProfilePictures/' . $_FILES['profilePicture']['name'];

            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $destination)) {
                $isSuccessUploadingImg = true;
            } else {
                $isSuccessUploadingImg = false;
            }
        }
        isset($destination) ? $query = 'UPDATE user SET firstName="' . $firstName . '",lastName="' . $lastName . '",email="' . $email . '",phoneNumber="' . $phoneNumber . '",birthday="' . $birthday . '",profilePicture="' . $destination . '" WHERE userId=' . $id . ''
            : $query = 'UPDATE user SET firstName="' . $firstName . '",lastName="' . $lastName . '",email="' . $email . '",phoneNumber="' . $phoneNumber . '",birthday="' . $birthday . '" WHERE userId=' . $id . '';
        $wrapper->executeUpdate($query) ? $isSuccessUpdatingUser = true : $isSuccessUpdatingUser = false;
    }

    if (!$isSuccessUpdatingUser) return 1;
    else if (!$isSuccessUploadingImg && (!empty($isSuccessUploadingImg))) return 2;
    else if (empty($currentPassword) || empty($newPassword)) return 3;
    else return 6;
}
function alreadyExists($email)
{
    $wrapper = new dbWrapper();

    $query = 'SELECT email FROM user WHERE email="' . $email . '"';

    $result = $wrapper->executeSingleRowQuery($query);

    $count = count($result);

    return ($count > 0);
}
