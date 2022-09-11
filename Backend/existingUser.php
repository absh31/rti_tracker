<?php
session_start();
include '../connection.php';

if (!isset($_POST['personalRTI'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    if (isset($_POST['existing']) && $_POST['existing'] == "yes") {
        $email = $_SESSION['email'] = $_POST['reqEmail'];
        $sql = $conn->prepare("SELECT * FROM tblapplicant WHERE applicant_email = ?");
        $sql->bindParam(1, $email);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $otp = rand(100000, 999999);
            $_SESSION['otpExisting'] = $otp;

            echo "<script>alert('Your OTP for verification is: " . $otp . "')</script>";
            echo "<script>window.open('../personalVerify.php','_self')</script>";
        } else {
            echo "<script>alert('No user found!')</script>";
            echo "<script>window.open('../instructionsRTI.php','_self')</script>";
        }
    }else{
        echo "<script>window.open('../submitRTI.php','_self')</script>";
    }
}
