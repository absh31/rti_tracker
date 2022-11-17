<?php
session_start();
include '../connection.php';

if (!isset($_POST['personalRTI'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    // if (isset($_POST['existing']) && $_POST['existing'] == "yes") {
    $email = $_SESSION['email'] = $_POST['reqEmail'];
    $sql = $conn->prepare("SELECT * FROM tblapplicant WHERE applicant_email = ?");
    $sql->bindParam(1, $email);
    $sql->execute();
    if ($sql->rowCount() > 0) {
        $otp = rand(100000, 999999);
        $_SESSION['existingUser'] = 1;
        $_SESSION['otp'] = $otp;
        $subject = "Email validation for RTI APPLICATION";
        $msg = "Your OTP for validation is: " . $otp;
        if (mail($email, $subject, $msg)) {
            echo "<script>alert('OTP has been sent to your entered email id!')</script>";
            echo "<script>window.open('../personalVerify.php','_self')</script>";
        } else {
            echo "<script>alert('Mail couldnt be send, please try again later!')</script>";
            echo "<script>window.open('../instructionsRTI.php','_self')</script>";
        }
    } else {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $subject = "Email validation for RTI APPLICATION";
        $msg = "Your OTP for validation is: " . $otp;
        if (mail($email, $subject, $msg)) {
            echo "<script>alert('OTP has been sent to your entered email id!')</script>";
            echo "<script>window.open('../personalVerify.php','_self')</script>";
        } else {
            echo "<script>alert('Mail couldnt be send, please try again later!')</script>";
            echo "<script>window.open('../instructionsRTI.php','_self')</script>";
        }
        echo "<script>alert('No users found, start with new application!')</script>";
        echo "<script>window.open('../submitRTI.php','_self')</script>";
    }
    // } else {
    //     echo "<script>window.open('../submitRTI.php','_self')</script>";
    // }
}
