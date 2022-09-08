<?php
session_start();
include '../connection.php';

if(!isset($_POST['personalRTI'])){
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
}else{
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['mobileNumber'] = $_POST['mobileNumber'];
    $_SESSION['phoneNumber'] = $_POST['phoneNumber'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['pincode'] = $_POST['pincode'];
    $_SESSION['country'] = $_POST['country'];
    $_SESSION['countryName'] = $_POST['countryName'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['status'] = $_POST['status'];
    $_SESSION['educationalStatus'] = $_POST['educationalStatus'];
    $_SESSION['education'] = $_POST['education'];
    echo "<script>alert('" . $otp . "')</script>";
    echo "<script>window.open('../personalVerify.php','_self')</script>";

}
?>