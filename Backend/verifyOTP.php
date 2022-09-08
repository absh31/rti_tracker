<?php
session_start();
include '../connection.php';
if (!isset($_POST['personalRTI'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    if ($_POST['otp'] == $_SESSION['otp']) {
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $mobileNumber = $_SESSION['mobileNumber'];
        $phoneNumber = $_SESSION['phoneNumber'];
        $gender = $_SESSION['gender'];
        $address = $_SESSION['address'];
        $pincode = $_SESSION['pincode'];
        $country = $_SESSION['country'];
        $countryName = $_SESSION['countryName'];
        if ($country == "Other") {
            $country = $countryName;
            $_SESSION['country'] = $country;
        }
        $state = $_SESSION['state'];
        $status = $_SESSION['status'];
        $eduStatus = $_SESSION['educationalStatus'];
        $edu = $_SESSION['education'];
        $sql = $conn->prepare("INSERT INTO `tblapplicant` (`applicant_name`, `applicant_email`, `applicant_mobile`, `applicant_phone`, `applicant_gender`, `applicant_education`, `applicant_more_education`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sql->bindParam(1, $name);
        $sql->bindParam(2, $email);
        $sql->bindParam(3, $mobileNumber);
        $sql->bindParam(4, $phoneNumber);
        $sql->bindParam(5, $gender);
        $sql->bindParam(6, $eduStatus);
        $sql->bindParam(7, $edu);
        if ($sql->execute()) {
            $_SESSION['otpVerified'] = 1;
            echo '<script>window.open("../submitRequest.php","_self")</script>';
        } else {
            echo '<script>alert("Something went Wrong!");</script>';
            echo '<script>window.open("../personalVerify.php","_self")</script>';
        }
    } else {
        echo '<script>alert("Wrong OTP");</script>';
        echo '<script>window.open("../personalVerify.php","_self")</script>';
    }
}
