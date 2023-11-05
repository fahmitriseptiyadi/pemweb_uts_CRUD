<?php
session_start();    


if (isset($_SESSION['auth'])) {


    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    $_SESSION['message']="Logged Out Succesfully";
    // redirect("index.php", "Product Updated Succesfully");

}

header('Location: index.php');

?>