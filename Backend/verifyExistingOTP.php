<?php
session_start();
include '../connection.php';
if (!isset($_POST['personalRTI'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    if ($_POST['otp'] == $_SESSION['otpExisting']) {
        $_SESSION['existingUser'] = 1;
        $_SESSION['otpVerified'] = 1;
        echo '<script>window.open("../submitRTI.php","_self")</script>';
    } else {
        echo '<script>alert("Wrong OTP");</script>';
        echo $_POST['otp'];
        echo $_POST['otpExisting'];

        exit;
        echo '<script>window.open("../personalVerify.php","_self")</script>';
    }
}
