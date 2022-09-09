<?php
session_start();
include '../connection.php';

if (!isset($_POST['personalRTI'])) {
    echo '<script>alert("Bad Request");</script>';
    echo '<script>window.open("../index.php","_self")</script>';
} else {
    if (empty($_POST['g-recaptcha-response'])) {
		echo "<script>alert('Captcha Error. Try Again')</script>";
		echo "<script>window.open('./submitRTI.php','_self')</script>";
	} else {
		$secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
		$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

		$response_data = json_decode($response);

		if (!$response_data->success) {
			echo "<script>alert('Captcha Error. Try Again')</script>";
			echo "<script>window.open('./submitRTI.php','_self')</script>";
		} else {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['mobileNumber'] = $_POST['mobileNumber'];
            $_SESSION['phoneNumber'] = $_POST['phoneNumber'];

            if ($_POST['gender'] == 'Male' || $_POST['gender'] == 'Female' || $_POST['gender'] == 'Other')
                $_SESSION['gender'] = $_POST['gender'];
            else {
                echo "<script>alert('Invalid gender selected!')</script>";
                echo "<script>window.open('../submitRTI.php','_self')</script>";
            }

            $_SESSION['address'] = $_POST['address'];
            $_SESSION['pincode'] = $_POST['pincode'];
            $_SESSION['country'] = $_POST['country'];
            $_SESSION['countryName'] = $_POST['countryName'];

            $states  = array("Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu & Kashmir", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Tripura", "Uttarakhand", "Uttar Pradesh", "West Bengal", "Andaman & Nicobar", "Chandigarh", "Dadra and Nagar Haveli", "Daman & Diu", "Delhi", "Lakshadweep", "Puducherry", "Other");

            if (in_array($_POST['state'], $states))
                $_SESSION['state'] = $_POST['state'];
            else {
                echo "<script>alert('Invalid state selected!')</script>";
                echo "<script>window.open('../submitRTI.php','_self')</script>";
            }

            if ($_POST['status'] == 'Rural' || $_POST['status'] == 'Urban')
                $_SESSION['status'] = $_POST['status'];
            else {
                echo "<script>alert('Invalid status selected!')</script>";
                echo "<script>window.open('../submitRTI.php','_self')</script>";
            }

            if ($_POST['educationalStatus'] == 'Literate' || $_POST['status'] == 'Illiterate')
                $_SESSION['educationalStatus'] = $_POST['educationalStatus'];
            else {
                echo "<script>alert('Invalid educational status selected!')</script>";
                echo "<script>window.open('../submitRTI.php','_self')</script>";
            }

            if ($_POST['education'] == 'Below' || $_POST['education'] == '12th' || $_POST['education'] == 'Graduate' || $_POST['education'] == 'Above')
                $_SESSION['education'] = $_POST['education'];
            else {
                echo "<script>alert('Invalid education selected!')</script>";
                echo "<script>window.open('../submitRTI.php','_self')</script>";
            }

            echo "<script>alert('Your OTP for verification is: " . $otp . "')</script>";
            echo "<script>window.open('../personalVerify.php','_self')</script>";
        }
    }
}
