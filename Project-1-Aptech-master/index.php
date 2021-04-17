<?php
session_start();
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    unset($_SESSION['login1']);
    unset($_SESSION['phone']);
    unset($_SESSION['name']);
    unset($_SESSION['city']);
    unset($_SESSION['address']); 
    unset($_SESSION['userID']); 
    unset($_SESSION['customerFname']);
    unset($_SESSION['customerLname']); 
    unset($_SESSION['email']);
}
// Include functions and connect to the database using PDO MySQL
include 'functions.php';
$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && file_exists('./subpage/'.$_GET['page'] . '.php') ? './subpage/'.$_GET['page'] : 'home';
// Include and show the requested page 
include("header.php");
include($page . '.php');
include("footer.php");


?>